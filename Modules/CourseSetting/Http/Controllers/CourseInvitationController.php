<?php

namespace Modules\CourseSetting\Http\Controllers;

use App\Exports\CourseStatisticsReport;
use App\Exports\QuizStatisticsReport;
use App\User;
use App\Jobs\SendInvitation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Modules\CourseSetting\Entities\Category;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgPosition;
use Modules\OrgSubscription\Entities\OrgSubscriptionCheckout;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\GeneralNotification;
use Modules\CourseSetting\Entities\Course;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Notification;

class CourseInvitationController extends Controller
{

    public function courseStatistics()
    {
        try {
            $categories = Category::get();
//            $courses = Course::with('enrollUsers', 'enrolls', 'enrolls.user')->where('type', 1)->get();
            $courses = [];
            $data = [];
            $data['overviewStatus']['not_start'] = 0;
            $data['overviewStatus']['in_process'] = 0;
            $data['overviewStatus']['finished'] = 0;
            $data['overviewStatus']['total_enrolled'] = 0;

            $data['quizStatistics']['not_start'] = 0;
            $data['quizStatistics']['fail'] = 0;
            $data['quizStatistics']['pass'] = 0;

            if (empty(request('type'))) {
                \request()->merge([
                    'type' => 1
                ]);
            }     if (empty(request('mode_of_delivery'))) {
                \request()->merge([
                    'mode_of_delivery' => 1
                ]);
            }

            if (request('type') == 1) {
                $statistics = $this->courseStatisticFilterQuery()->get();
                foreach ($statistics as $statistic) {
                    $status = $statistic->totalStatistic();
                    $data['overviewStatus']['not_start'] = $data['overviewStatus']['not_start'] + $status['not_start'];
                    $data['overviewStatus']['in_process'] = $data['overviewStatus']['in_process'] + $status['in_process'];
                    $data['overviewStatus']['finished'] = $data['overviewStatus']['finished'] + $status['finished'];
                    $data['overviewStatus']['total_enrolled'] = $data['overviewStatus']['total_enrolled'] + $status['total_enroll'];

                }
            } else {
                $quizStatistics = $this->courseStatisticFilterQuery()->get();
                foreach ($quizStatistics as $statistic) {
                    $status = $statistic->totalQuizStatistic();
                    $data['quizStatistics']['not_start'] = $data['quizStatistics']['not_start'] + $status['not_start'];
                    $data['quizStatistics']['fail'] = $data['quizStatistics']['fail'] + $status['fail'];
                    $data['quizStatistics']['pass'] = $data['quizStatistics']['pass'] + $status['pass'];
                }
            }
            if (isModuleActive('Org')) {
                $data['positions'] = OrgPosition::orderBy('order', 'asc')->get();
                $data['branches'] = OrgBranch::where('parent_id', 0)->orderBy('order', 'asc')->get();
            }
            return view('coursesetting::statistics', $data, compact('courses', 'categories'));
        } catch (\Exception $e) {
            dd($e);
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }


    public function enrolled_students($course_id)
    {
        try {
            $course = Course::find($course_id);
            $students = [];
            return view('coursesetting::student_list', compact('students', 'course'));

        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }


    public function getAllStudentData(Request $request, $course_id)
    {

        $course = Course::find($course_id);
        $query = $course->enrollUsers;

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($query) {
                return " <div class=\"profile_info\"><img src='" . getStudentImage($query->image) . "'   alt='" . $query->name . " image'></div>";
            })->addColumn('student_name', function ($query) {
                return '<a class="dropdown-item" target="_blank" href="' . route('student.courses', $query->id) . '" data-id="' . $query->id . '" type="button">' . $query->name . '</a>';

            })->editColumn('email', function ($query) {
                return $query->email;

            })
            ->editColumn('phone', function ($query) {
                return $query->phone;

            })
            ->addColumn('progressbar', function ($query) use ($course) {
                return "  <div class='progress_percent flex-fill text-right'>
                                                    <div class='progress theme_progressBar '>
                                                        <div class='progress-bar' role='progressbar'
                                                             style='width:" . round($course->userTotalPercentage($query->id, $course->id)) . "%'
                                                             aria-valuenow='25'
                                                             aria-valuemin='0' aria-valuemax='100'></div>
                                                    </div>
                                                    <p class='font_14 f_w_400'>" . round($course->userTotalPercentage($query->id, $course->id)) . "% Complete</p>
                                                </div>";

            })
            ->editColumn('dob', function ($query) {
                return showDate($query->dob);

            })
            ->addColumn('start_working_date', function ($query) {
                if (isModuleActive('Org')) {
                    return showDate($query->start_working_date);
                } else {
                    return '';
                }

            })
            ->editColumn('country', function ($query) {
                return $query->userCountry->name;

            })
            ->addColumn('status', function ($query) {

                $checked = $query->status == 1 ? "checked" : "";
                $view = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           id="active_checkbox' . $query->id . '" value="' . $query->id . '"
                                                             ' . $checked . '><i class="slider round"></i></label>';

                return $view;
            })->addColumn('notify_user', function ($query) use ($course) {
                if (round($course->userTotalPercentage($query->id, $course->id)) < 100) {
                    $link = '<a class="" href="' . route('course.courseStudentNotify', [$course->id, $query->id]) . '" data-id="' . $query->id . '" type="button">Notify</a>';
                } else {
                    $link = '';

                }
                return $link;


            })->rawColumns(['status', 'progressbar', 'image', 'notify_user', 'action', 'student_name'])
            ->make(true);
    }


    public function courseStudentNotify($course_id, $student_id)
    {
        try {
            $course = Course::find($course_id);
            $user = User::find($student_id);
            $percentage = round($course->userTotalPercentage($student_id, $course_id));
            $message = "You have complete " . $percentage . "% of " . $course->title . ". Please complete as soon as possible";
            $details = [
                'title' => 'Incomplete course reminder',
                'body' => $message,
                'actionText' => 'Visit',
                'actionURL' => route('courseDetailsView', $course->slug),
            ];
            Notification::send($user, new GeneralNotification($details));
            Toastr::success('Operation Done Successfully', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }

    }


    public function courseStatisticFilterQuery()
    {
        $query = Course::with('category', 'user', 'enrolls');
        if (\request('type')) {
            $query->where('type', \request('type'));
        }
        if (\request('category')) {
            $category = Category::find(request('category'));
            if ($category) {

                $ids = $category->getAllChildIds($category, [$category->id]);

                if (request('type') != 2) {
                    $query->whereIn('category_id', $ids);
                    $query->orWhereIn('subcategory_id', $ids);
                }
                if (request('type') != 1) {
                    $query->orWhereHas('quiz', function ($q) use ($ids) {
                        $q->whereIn('category_id', $ids);
                        $q->orWhereIn('sub_category_id', $ids);
                    });
                }

            }
        }
        if (isModuleActive('Org')) {
            if (\request('required_type') == '0') {
                $query->where('required_type', '=', '0');
            }
            if (\request('required_type') == '1') {
                $query->where('required_type', '=', '1');
            }
            if (\request('mode_of_delivery')) {
                $query->where('mode_of_delivery', \request('mode_of_delivery'));
            }

            $query->whereHas('enrolls', function ($q) {
                $q->whereHas('user', function ($query) {
                    if (request('org_branch_code_search')) {
                        $query->where('org_chart_code', request('org_branch_code_search'));

                    }
                    if (request('job_position')) {
                        $query->where('org_position_code', request('job_position'));
                    }
                });
            });
        }

        $query->whereHas('enrolls', function ($q) {
            $q->whereHas('user', function ($query) {
                if (request('student_status') == "0") {
                    $query->where('status', "0");
                }
                if (request('student_status') == "1") {
                    $query->where('status', "1");
                }
            });
        });

        if (isInstructor()) {
            $query->where('user_id', '=', Auth::id());
            $query->orWhere('assistant_instructors', 'like', '%"{' . Auth::id() . '}"%');
        }
        return $query;
    }

    public function courseStatisticsCourseData()
    {

        $query = $this->courseStatisticFilterQuery();
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('required_type', function ($query) {
                return $query->required_type == 1 ? trans('courses.Compulsory') : trans('courses.Open');
            })->editColumn('mode_of_delivery', function ($query) {
                if ($query->mode_of_delivery == 1) {
                    $title = trans('courses.Online');

                } elseif ($query->mode_of_delivery == 2) {
                    $title = trans('courses.Distance Learning');
                } else {
                    if (isModuleActive('Org')) {
                        $title = trans('courses.Offline');
                    } else {
                        $title = trans('courses.Face-to-Face');
                    }
                }
                return $title;
            })
            ->addColumn('type', function ($query) {
                return $query->type == 1 ? trans('courses.Course') : trans('quiz.Quiz');

            })
            ->editColumn('total_enrolled', function ($query) {
                return $query->totalStatistic()['total_enroll'];
            })
            ->addColumn('not_start', function ($query) {
                return $query->totalStatistic()['not_start'];
            })
            ->addColumn('in_process', function ($query) {
                return $query->totalStatistic()['in_process'];
            })
            ->addColumn('finished', function ($query) {
                return $query->totalStatistic()['finished'];
            })
            ->addColumn('finished_rate', function ($query) {
                $finished = $query->totalStatistic()['finished'];
                $total = $query->total_enrolled;
                $percentage = 0;
                if ($total != 0) {
                    $percentage = ($finished / $total) * 100;
                    if ($percentage > 100) {
                        $percentage = 100;
                    }
                }
                return round($percentage) . '%';
            })
            ->make(true);
    }

    public function courseStatisticsQuizData()
    {
        $query = $this->courseStatisticFilterQuery();

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('required_type', function ($query) {
                return $query->required_type == 1 ? trans('courses.Compulsory') : trans('courses.Open');
            })->editColumn('mode_of_delivery', function ($query) {
                if ($query->mode_of_delivery == 1) {
                    $title = trans('courses.Online');

                } elseif ($query->mode_of_delivery == 2) {
                    $title = trans('courses.Distance Learning');
                } else {
                    if (isModuleActive('Org')) {
                        $title = trans('courses.Offline');
                    } else {
                        $title = trans('courses.Face-to-Face');
                    }
                }
                return $title;
            })
            ->addColumn('type', function ($query) {
                return $query->type == 1 ? trans('courses.Course') : trans('quiz.Quiz');

            })
            ->editColumn('total_enrolled', function ($query) {
                return $query->totalQuizStatistic()['total_enroll'];
            })
            ->addColumn('not_start', function ($query) {
                return $query->totalQuizStatistic()['not_start'];
            })
            ->addColumn('fail', function ($query) {
                return $query->totalQuizStatistic()['fail'];
            })
            ->addColumn('pass', function ($query) {
                return $query->totalQuizStatistic()['pass'];
            })
            ->addColumn('pass_rate', function ($query) {
                $pass = $query->totalQuizStatistic()['pass'];
                $total = $query->total_enrolled;
                $percentage = 0;
                if ($total != 0) {
                    $percentage = ($pass / $total) * 100;
                    if ($percentage > 100) {
                        $percentage = 100;
                    }
                }
                return $percentage . '%';
            })
            ->make(true);
    }


    public function courseStatisticsCourseReport()
    {
        return Excel::download(new CourseStatisticsReport(), 'course-statistic-report.xlsx');
    }

    public function courseStatisticsQuizReport()
    {
        return Excel::download(new QuizStatisticsReport(), 'quiz-statistic-report.xlsx');
    }

}
