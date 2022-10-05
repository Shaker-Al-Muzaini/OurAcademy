@extends('backend.master')

@section('table')
    @php
        $table_name='sliders';
    @endphp
    {{$table_name}}
@stop
@section('mainContent')


    @include("backend.partials.alertMessage")

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('frontendmanage.Slider List')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('frontendmanage.Frontend CMS')}}</a>
                    <a class="active" href="{{route('frontend.sliders.index')}}">{{__('frontendmanage.Sliders')}}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="main-title">
                        <h3 class="mb-20">{{__('frontendmanage.Slider Setting')}}</h3>
                    </div>

                    <div class="">
                        <div class="row">

                            <div class="col-lg-12">
                                <!-- tab-content  -->
                                <div class="tab-content " id="myTabContent">
                                    <!-- General -->
                                    <div class="tab-pane fade white_box_30px show active" id="Activation"
                                         role="tabpanel" aria-labelledby="Activation-tab">
                                        <div class="main-title mb-25">


                                            <form action="{{route('frontend.sliders.setting')}}" id="" method="POST" enctype="multipart/form-data">

                                                @csrf
                                                <div class="single_system_wrap">
                                                    <div class="row">


                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-3">
                                                                        <label class="primary_input_label"
                                                                               for="">  {{__('common.Transition time')}}</label>
                                                                    </div>
                                                                    <div class="col-md-6 mb-25">
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{__('common.Transition time')}}"
                                                                               type="number" name="slider_transition_time" min="1"
                                                                               value="{{Settings('slider_transition_time')?Settings('slider_transition_time'):5}}">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>


                                                <div class="submit_btn  mt-4">
                                                    <button class="primary-btn small fix-gr-bg" type="submit"
                                                            data-toggle="tooltip" title="" id="general_info_sbmt_btn"><i
                                                            class="ti-check"></i> {{__('common.Save')}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
@endpush
