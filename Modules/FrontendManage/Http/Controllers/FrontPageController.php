<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\FrontendManage\Entities\FrontPage;

class FrontPageController extends Controller
{
    use ImageStore;

    public function index()
    {

        $data['frontPages'] = FrontPage::where('is_static', '=', '0')->latest()->get();
        return view('frontendmanage::front_page.index', $data);
    }


    public function create()
    {
        return view('frontendmanage::front_page.create');
    }

    public function store(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'title' => 'required',
            'details' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $frontpage = new FrontPage();

            foreach ($request->title as $key => $value) {
                $frontpage->setTranslation('title', $key, $value);
            }
            foreach ($request->sub_title as $key => $value) {
                $frontpage->setTranslation('sub_title', $key, $value);
            }
            foreach ($request->details as $key => $value) {
                $frontpage->setTranslation('details', $key, $value);
            }

            $frontpage->is_static = 0;
            $frontpage->save();

            if ($request->banner != null) {
                $frontpage->banner = $this->saveImage($request->banner);
                $frontpage->is_static = 0;
            }

            $frontpage->name = $frontpage->title;

            $frontpage->slug = $this->createSlug(empty($request->slug) ? $frontpage->title : $request->slug);
            $frontpage->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.page.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function show($id)
    {
        return view('frontendmanage::front_page.show');
    }


    public function edit($id)
    {
        $data['editData'] = FrontPage::findOrFail($id);
        return view('frontendmanage::front_page.create', $data);

    }

    public function update(Request $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $page = FrontPage::findOrFail($id);
        try {
            $rules = [
                'title' => 'required',
            ];
            $this->validate($request, $rules, validationMessage($rules));


            foreach ($request->title as $key => $value) {
                $page->setTranslation('title', $key, $value);
            }
            foreach ($request->sub_title as $key => $value) {
                $page->setTranslation('sub_title', $key, $value);
            }
            foreach ($request->details as $key => $value) {
                $page->setTranslation('details', $key, $value);
            }
            $page->name = $page->title;
            $page->slug = $this->createSlug(empty($request->slug) ? $page->title : $request->slug);

            if ($request->banner != null) {
                $page->banner = $this->saveImage($request->banner);
            }

            $page->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.page.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }


    }

    public function destroy($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            FrontPage::where('id', $id)->delete();
            Toastr::success('Operation done successfully.', 'Success');
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    protected function createSlug(string $title): string
    {

        $slugsFound = $this->getSlugs($title);

        $counter = 0;
        $counter += $slugsFound;

        $slug = Str::slug($title) == "" ? str_replace(' ', '-', $title) : Str::slug($title);


        if ($counter) {
            $slug = $slug . '-' . $counter;
        }
        return $slug;
    }


    protected function getSlugs($title): int
    {
        return FrontPage::select()->where('title', 'like', $title)->count();
    }
}
