@extends('backend.master')

@section('mainContent')
    <section class="sms-breadcrumb mb-20 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('frontendmanage.Pages')}}</h1>
                <div class="bc-pages">
                    <a href="#">@if(isset($editData))
                            {{__('common.Edit')}}
                        @else
                            {{__('common.Add')}}
                        @endif {{__('frontendmanage.Page')}}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            @if(isset($editData))
                <div class="row">
                    <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20"><a target="_blank"
                                                                                     href="{{route('frontPage',$editData->slug)}}"
                                                                                     class="primary-btn small fix-gr-bg"> <span
                                class="ti-eye pr-2"></span> {{__('student.Preview')}} </a></div>
                </div>
            @endif


            <div class="row">
                <div class="col-lg-12">

                    <div class="white-box  student-details header-menu">
                        @if(isset($editData))
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => route('frontend.page.update',$editData->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                        @else
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'frontend.page.store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_studentA']) }}
                        @endif
                        <div class="row">
                            <div class="col-lg-12">
                                @php
                                    $LanguageList = getLanguageList();
                                @endphp
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
                                <div class="tab-content">
                                    @foreach ($LanguageList as $key => $language)
                                        <div role="tabpanel"
                                             class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                             id="element{{$language->code}}">
                                            <div class="row">
                                                <div class="col-lg-12  ">
                                                    <div class="primary_input mb-25">
                                                        <label
                                                            class="'primary_input_label">{{__('frontendmanage.Title')}}
                                                            <span>*</span> </label>
                                                        <input
                                                            class="primary_input_field form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                            type="text" name="title[{{$language->code}}]"
                                                            autocomplete="off"
                                                            value="{{isset($editData)? $editData->getTranslation('title',$language->code) : '' }}">

                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('title'))
                                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('title') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 ">
                                                    <div class="primary_input mb-25">
                                                        <label
                                                            class="'primary_input_label">{{__('frontendmanage.Sub Title')}} </label>
                                                        <input
                                                            class="primary_input_field form-control{{ $errors->has('sub_title') ? ' is-invalid' : '' }}"
                                                            type="text" name="sub_title[{{$language->code}}]"
                                                            autocomplete="off"
                                                            value="{{isset($editData)? $editData->getTranslation('sub_title',$language->code) : '' }}">

                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('sub_title'))
                                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('sub_title') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 ">
                                                    <div class="primary_input mb-25">
                                                        <label
                                                            class="'primary_input_label">{{__('frontendmanage.Details')}}
                                                            <span>*</span> </label>
                                                        <textarea
                                                            class="form-control summernote-editor {{ $errors->has('details') ? ' is-invalid' : '' }}"
                                                            rows="5" name="details[{{$language->code}}]" cols="50"
                                                            style="display: none;">{{isset($editData)? $editData->getTranslation('details',$language->code) : '' }}</textarea>

                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('details'))
                                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('details') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 ">
                                        <div class="primary_input mb-25">
                                            <label class="'primary_input_label">{{__('frontendmanage.Slug')}} </label>
                                            <input
                                                class="primary_input_field form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                                                type="text" name="slug" autocomplete="off"
                                                value="{{isset($editData)? $editData->slug : '' }}">

                                            <span class="focus-border"></span>
                                            @if ($errors->has('sub_title'))
                                                <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('slug') }}</strong>
                                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-8  ">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="">
                                            </label>
                                            <div class="primary_file_uploader">
                                                <input
                                                    class="primary_input_field  filePlaceholder {{ @$errors->has('banner') ? ' is-invalid' : '' }}"
                                                    type="text" id=""
                                                    placeholder="Browse file"
                                                    readonly="" {{ $errors->has('instructor_banner') ? ' autofocus' : '' }}>
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg"
                                                           for="file1">{{ __('frontendmanage.Banner') }}</label>
                                                    <input type="file" class="d-none fileUpload imgInput1"
                                                           name="banner" id="file1">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4  ">
                                        <div class="primary_input mb-25">
                                            <img height="70" class=" imagePreview1" style="max-width: 100%"
                                                 src="@if(isset($editData)){{ asset('/'.$editData->banner)}}@endif"
                                                 alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(isset($editData))
                                <div class="col-lg-12 mt-40 text-center tooltip-wrapper">
                                    <button class="primary-btn fix-gr-bg tooltip-wrapper ">
                                        <span class="ti-check"></span>
                                        {{__('common.Update')}}
                                    </button>
                                </div>

                            @else

                                <div class="col-lg-12 mt-40 text-center tooltip-wrapper">
                                    <button class="primary-btn fix-gr-bg tooltip-wrapper ">
                                        <span class="ti-check"></span>
                                        {{__('common.Add')}}
                                    </button>
                                </div>

                            @endif

                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
@push('scripts')
    <script>
        $('.summernote-editor').summernote({
            placeholder: 'Write here',
            tabsize: 2,
            height: 200
        });
        $('.popover').css("display", "none");

        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview1").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput1").change(function () {
            readURL1(this);
        });

    </script>
@endpush
