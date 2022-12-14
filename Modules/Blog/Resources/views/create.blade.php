@extends('backend.master')

@section('mainContent')
    @php
        $LanguageList = getLanguageList();
    @endphp
    <link rel="stylesheet" href="{{asset('Modules/Blog/Resources/views/assets/taginput/tagsinput.css')}}"/>

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('blog.Blogs')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('blog.Blogs')}}</a>
                    <a href="#">{{__('common.Add New')}}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid ">


            <div class="white_box mb_30">
                <div class="white_box_tittle list_header">
                    <h4>{{__('common.Add New')}} {{__('blog.Blog')}}</h4>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="student-details header-menu">
                                <div class="row pt-0">
                                    @if(isModuleActive('FrontendMultiLang'))
                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                            role="tablist">
                                            @foreach ($LanguageList as $key => $language)
                                                <li class="nav-item">
                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                       href="#element{{$language->code}}"
                                                       role="tab"
                                                       data-toggle="tab">{{ $language->native }}  </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <form action="{{route('blogs.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="tab-content">
                                        @foreach ($LanguageList as $key => $language)
                                            <div role="tabpanel"
                                                 class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                 id="element{{$language->code}}">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">  {{__('blog.Title')}}
                                                                <strong
                                                                    class="text-danger">*</strong>
                                                            </label>
                                                            <input class="primary_input_field addTitle"
                                                                   name="title[{{$language->code}}]"
                                                                   placeholder="-"
                                                                   type="text"
                                                                   value="{{old('title')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-35">
                                                            <label class="primary_input_label"
                                                                   for="">{{__('blog.Blog')}} {{__('blog.Description')}}

                                                            </label>
                                                            <textarea class="lms_summernote"
                                                                      name="description[{{$language->code}}]" id=""
                                                                      cols="30"

                                                                      rows="10">{{old('description')}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="row">


                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">  {{__('blog.Slug')}}
                                                    <strong
                                                        class="text-danger">*</strong>
                                                </label>
                                                <input class="primary_input_field addSlug" name="slug"
                                                       placeholder="-"
                                                       type="text"
                                                       value="{{old('slug')}}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 courseBox mb-25">
                                            <label class="primary_input_label"
                                                   for=""> {{__('quiz.Category')}}
                                                <strong
                                                    class="text-danger">*</strong>
                                            </label>
                                            <select class="primary_select category_id" name="category"
                                                    id="category_id" {{$errors->has('category') ? 'autofocus' : ''}}>
                                                <option
                                                    data-display="{{__('common.Select')}} {{__('quiz.Category')}} *"
                                                    value="">{{__('common.Select')}} {{__('quiz.Category')}} </option>
                                                @foreach($categories as $category)
                                                    <option
                                                        value="{{$category->id}}">{{@$category->title}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xl-12 courseBox mb-25" id="subCategoryDiv">


                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">  {{ __('common.Tags') }}

                                                </label>
                                                <input type="text" data-role="tagsinput" name="tags"
                                                       class="primary_input_field">

                                            </div>

                                        </div>
                                    </div>


                                    <div class="row mt-20">
                                        <div class="col-xl-4">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">{{__('blog.Thumbnail') }} (Recommend size: 1170x600)

                                                </label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input filePlaceholder" type="text"
                                                           id=""
                                                           placeholder="{{__('blog.Browse Image File')}}"
                                                           readonly="">
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg"
                                                               for="document_file_2">{{__('common.Browse') }}</label>
                                                        <input type="file" class="d-none fileUpload" name="image"
                                                               id="document_file_2">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="primary_input">
                                                <label class="primary_input_label"
                                                       for="">{{ __('blog.Publish Date') }}</label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="Start Date"
                                                                       class="primary_input_field primary-input date form-control"
                                                                       id="start_date" type="text"
                                                                       name="publish_date"
                                                                       value="{{date('m/d/Y')}}"
                                                                       autocomplete="off">

                                                            </div>
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="primary_input">
                                                <label class="primary_input_label"
                                                       for="">{{ __('blog.Publish Time') }}</label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="Start Time"
                                                                       class="primary_input_field primary-input time form-control"
                                                                       id="start_time" type="text"
                                                                       name="publish_time"
                                                                       value="{{date('H:i:s')}}"
                                                                       autocomplete="off">

                                                            </div>
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-time" id="start-time-icon"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        @if(isModuleActive('OrgInstructorPolicy'))
                                            <div class="col-xl-4 ">
                                                <div class="primary_input mb-25">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="primary_input_label"
                                                                   for=""> {{__('blog.Target Audience')}}</label>
                                                        </div>
                                                        <div class="col-md-6 mb-25">
                                                            <label class="primary_checkbox d-flex mr-12"
                                                                   for="type1">
                                                                <input type="radio"
                                                                       class="common-radio type1"
                                                                       id="type1"
                                                                       name="audience"
                                                                       value="1" checked>
                                                                <span
                                                                    class="checkmark mr-2"></span> {{__('blog.Public')}}
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6  mb-25">
                                                            <label class="primary_checkbox d-flex mr-12"
                                                                   for="type2">
                                                                <input type="radio"
                                                                       class="common-radio type2"
                                                                       id="type2"
                                                                       name="audience"
                                                                       data-toggle="modal" data-target="#selectBranch"
                                                                       value="2">
                                                                <span
                                                                    class="checkmark mr-2"></span> {{__('blog.Specify')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade admin-query" id="selectBranch">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">


                                                        <div class="modal-header">
                                                            <h4 class="modal-title">{{__('common.Select')}} {{__('blog.Org Branch')}} </h4>
                                                            <button type="button" class="close" data-dismiss="modal"><i
                                                                    class="ti-close "></i></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="text-center">

                                                                <div class="white_boxx ">
                                                                    <div class="org_table ">
                                                                        @livewire('show-policy-branch',['codes' =>
                                                                        $codes])
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mt-40 d-flex justify-content-center">
                                                                <button class="primary-btn float-right fix-gr-bg"
                                                                        data-dismiss="modal"
                                                                        type="button">{{__('common.Add')}}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>


                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg"
                                                    id="save_button_parent"
                                                    type="submit"><i
                                                    class="ti-check"></i> {{__('common.Add') }} {{__('blog.Blog') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>



    <script src="{{asset('public/backend/js/blog_list.js')}}"></script>

@endsection

@push('scripts')

    <script src="{{asset('Modules/Blog/Resources/views/assets/taginput/tagsinput.js')}}"></script>
    <script>
        $(document).on("click", ".changeOrgStatus", function () {
            return false;
        });

        $('#selectBranch').on('hidden.bs.modal', function () {
            let total = $('.changeOrgStatus:checked').length;
            if (total === 0) {
                $('#type1').prop('checked', true);
            }
        })
    </script>

@endpush
