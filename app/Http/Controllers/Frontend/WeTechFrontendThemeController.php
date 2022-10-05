<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;

class WeTechFrontendThemeController extends Controller
{
    public function route($route_name, Request $request)
    {
        if ($route_name == 'quizList') {
            if ($request->type == 'online') {
                $mode_of_delivery = 1;
            } elseif ($request->type == 'offline') {
                $mode_of_delivery = 3;
            } else {
                $mode_of_delivery = '';
            }
            $type = $request->type;
            $status = $request->status;
            $with = ['course', 'course.activeReviews', 'course.courseLevel', 'course.BookmarkUsers', 'course.user', 'course.reviews', 'course.enrollUsers'];
            $with[] = 'course.quiz';
            $with[] = 'course.quiz.assign';
            $query = CourseEnrolled::where('user_id', Auth::user()->id)
                ->whereHas('course', function ($query) use ($type) {
                    $query->where('type', '=', 2);
                });
            if (!empty($mode_of_delivery)) {
                $query->whereHas('course', function ($query) use ($mode_of_delivery) {
                    $query->where('mode_of_delivery', '=', $mode_of_delivery);
                });
            }
            if ($request->limit == 1) {
                $limit = true;
            } else {
                $limit = false;
            }
            $query->with($with);
            $courses = $query->get();

            return view(theme('partials._quiz_list'), compact('courses', 'type', 'status', 'limit'));
        } elseif ($route_name == 'courseList') {

            if ($request->type == 'online') {
                $mode_of_delivery = 1;
            } elseif ($request->type == 'offline') {
                $mode_of_delivery = 3;
            } else {
                $mode_of_delivery = '';
            }
            $type = $request->type;
            $status = $request->status;
            $search = $request->search;

            $with = ['course', 'course.activeReviews', 'course.courseLevel', 'course.BookmarkUsers', 'course.user', 'course.reviews', 'course.enrollUsers'];
            $with[] = 'course.quiz';
            $with[] = 'course.quiz.assign';
            $query = CourseEnrolled::where('user_id', Auth::user()->id)
                ->whereHas('course', function ($query) use ($type) {
                    if (\request()->type == 'class') {
                        $course_type = [3];
                    } elseif (\request()->type == 'online' || \request()->type == 'offline') {
                        $course_type = [1];
                    } else {
                        $course_type = [1, 3];
                    }
                    $query->whereIn('type', $course_type);
                });
            if (!empty($mode_of_delivery)) {
                $query->whereHas('course', function ($query) use ($mode_of_delivery) {
                    $query->where('mode_of_delivery', '=', $mode_of_delivery);
                });
            }
            if (!empty($search)) {
                $query->whereHas('course', function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%{$search}%");

                });
            }
            if ($request->limit == 1) {
                $limit = true;
            } else {
                $limit = false;
            }
            $query->with($with);
            $courses = $query->get();

            return view(theme('partials._course_list'), compact('courses', 'type', 'status', 'limit', 'search'));
        } elseif ($route_name == 'learningScheduleList') {
            $month = $request->month;
            $year = $request->year;

            $open_started = CourseEnrolled::whereYear('created_at', '=', $year)
                ->whereMonth('created_at', '=', $month)
                ->with('course')
                ->whereHas('course', function ($q) {
                    $q->where('required_type', 0);

                })
                ->where('user_id', \auth()->id())
                ->get();

            $close_started = CourseEnrolled::with('orgSubscriptionPlan', 'course')
                ->whereHas('course', function ($q) {
                    $q->where('required_type', 1);

                })
                ->whereHas('orgSubscriptionPlan', function ($q) use ($month, $year) {
                    $q->whereHas('checkouts', function ($q2) use ($month, $year) {
                        $q2->whereMonth('start_date', '=', $month);
                        $q2->whereYear('start_date', '=', $year);
                        $q2->whereYear('user_id', '=', \auth()->id());
                    });

                })

                ->where('user_id', \auth()->id())
                ->get();

            $ended = CourseEnrolled::whereYear('subscription_validity_date', '=', $year)
                ->whereMonth('subscription_validity_date', '=', $month)
                ->with('orgSubscriptionPlan', 'course')
                ->where('user_id', \auth()->id())
                ->get();

            return view(theme('partials._schedule_list'), compact('month', 'year', 'open_started', 'close_started', 'ended'));
        } else {
            return '';
        }
    }
}
