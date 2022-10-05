@extends('backend.master')
@section('mainContent')
    @push('styles')
        <link href="{{asset('public/backend/vendors/nestable/jquery.nestable.min.css')}}" rel="stylesheet">
        <link href="{{asset('public/backend/css/headermenu.css')}}" rel="stylesheet">
    @endpush


    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('frontendmanage.Home Content')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('frontendmanage.Frontend CMS')}}</a>
                    <a class="active"
                       href="{{url('frontendmanage.sectionSetting')}}">{{__('frontendmanage.Menu Manager')}}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">
                                    @lang('common.Add') @lang('frontendmanage.Header Menu')
                                </h3>
                            </div>
                            @include('frontendmanage::headermenu.menu_list')

                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-30">@lang('frontendmanage.Menu List')</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" id="menuList">
                            @include('frontendmanage::headermenu.submenu_list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Delete Modal Start --}}
        <div class="modal fade admin-query" id="deleteSubmenuItem">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('common.Delete') @lang('frontendmanage.Sub Menu')</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <h4>@lang('common.Are you sure to delete ?')</h4>
                        </div>
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-dismiss="modal">@lang('common.Cancel')</button>
                            <input type="hidden" name="id" id="item-delete" value="">
                            <a class="primary-btn fix-gr-bg" id="delete-item" href="#">@lang('common.Delete')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="headermenu_reordering_url" value="{{route('frontend.headermenu.reordering')}}">
        <input type="hidden" id="headermenu_delete_url" value="{{ route('frontend.headermenu.delete') }}">
        <input type="hidden" id="headermenu_edit_url" value="{{route('frontend.headermenu.edit-element')}}">
        <input type="hidden" id="headermenu_add_url" value="{{route('frontend.headermenu.add-element')}}">
        <input type="hidden" id="header_token" value="{{csrf_token()}}">
        {{-- Delete Modal End --}}
    </section>
    @push('scripts')
        <script src="{{asset('public/backend/vendors/nestable/jquery.nestable.min.js')}}"></script>
        <script src="{{asset('public/backend/js/headermenu.js')}}"></script>
    @endpush
@endsection
