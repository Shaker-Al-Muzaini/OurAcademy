@extends('backend.master')

@php
    $table_name='blogs';
@endphp
@section('table'){{$table_name}}@endsection
@section('mainContent')
    <link rel="stylesheet" href="{{asset('Modules/Blog/Resources/views/assets/taginput/tagsinput.css')}}"/>

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('blog.Blogs')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('blog.Blogs')}}</a>
                    <a href="#">{{__('blog.Blog List')}}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center mt-50">

                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px"> {{__('blog.Blog List')}}</h3>
                            @if (permissionCheck('blog.create'))
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                           href="{{route('blogs.create')}}"><i
                                                class="ti-plus"></i>{{__('common.Add')}} {{__('blog.Blog')}}</a></li>
                                </ul>
                            @endif
                        </div>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">

                                <table id="lms_table" class="table Crm_table_active_blog">
                                    <thead>
                                    <tr>
                                        <th scope="col"> {{__('blog.SL')}}</th>
                                        <th scope="col"> {{__('blog.Title')}}</th>
                                        <th scope="col"> {{__('common.Category')}}</th>
                                        @if(isModuleActive('Org'))
                                            <th scope="col"> {{__('blog.Target Audience')}}</th>
                                        @endif
                                        <th scope="col"> {{__('common.Tags')}}</th>
                                        <th scope="col"> {{__('blog.Authored Date')}}</th>
                                        <th scope="col"> {{__('blog.Viewed')}}</th>
                                        <th scope="col">{{__('common.Status')}}</th>
                                        <th scope="col">{{__('common.Action')}}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($blogs as $key => $blog)
                                        <tr>
                                            <td class=""><span class="m-2">{{++$key}}</span></td>
                                            <td>{{@$blog->title}}</td>
                                            <td>{{@$blog->category->title}}</td>
                                            @if(isModuleActive('Org'))
                                                <td>
                                                    @if($blog->audience==1)
                                                        {{trans('blog.Public')}}
                                                    @else
                                                        @foreach($blog->branches as $branch)
                                                            <p class="text-nowrap">{{$branch->branch->getFullTextPathAttribute()}}</p>
                                                        @endforeach
                                                    @endif
                                                </td>
                                            @endif
                                            <td>{{@$blog->tags}}</td>
                                            <td>
                                                <p class="text-nowrap">
                                                    {{ showDate(@$blog->authored_date ) }}
                                                </p>
                                                <p class="text-nowrap">
                                                    {{ $blog->authored_time }}
                                                </p>
                                            </td>
                                            <td>{{@$blog->viewed}}</td>
                                            <td>
                                                <label class="switch_toggle" for="active_checkbox{{@$blog->id }}">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           id="active_checkbox{{@$blog->id }}"
                                                           @if (@$blog->status == 1) checked
                                                           @endif value="{{@$blog->id }}">
                                                    <i class="slider round"></i>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{__('common.Action')}}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu2">
                                                        <a target="_blank"
                                                           href="{{route('blogDetails',[$blog->slug])}}?preview=1"
                                                           class="dropdown-item" type="button">{{__('common.View')}}</a>
                                                        @if (permissionCheck('blog.edit'))
                                                            <a href="{{route('blogs.edit',$blog->id)}}"
                                                               class="dropdown-item"
                                                            >{{__('common.Edit')}}</a>
                                                        @endif
                                                        @if (permissionCheck('blog.delete'))
                                                            <button data-id="{{$blog->id}}"
                                                                    class="deleteBlog dropdown-item"
                                                                    type="button">{{__('common.Delete')}}</button>

                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade admin-query" id="deleteBlog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{route('blogs.destroy')}}"
                                  method="post">
                                @csrf

                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('common.Delete')}} {{__('blog.Blog')}} </h4>
                                    <button type="button" class="close" data-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>

                                <div class="modal-body">
                                    <div class="text-center">

                                        <h4>{{__('common.Are you sure to delete ?')}} </h4>
                                    </div>

                                    <div class="mt-40 d-flex justify-content-between">

                                        <input type="hidden" name="id" value="" id="blogDeleteId">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-dismiss="modal">{{__('common.Cancel')}}</button>
                                        <button class="primary-btn fix-gr-bg"
                                                type="submit">{{__('common.Delete')}}</button>


                                    </div>
                                </div>
                            </form>
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
        // $('.addTags').tagsinput('items');

        let datatable = $('.Crm_table_active_blog').DataTable({
            bLengthChange: true,
            "bDestroy": true,

            columns: [
                {orderable: true},
                {orderable: true},
                    @if(isModuleActive('Org'))
                {
                    orderable: true
                },
                    @endif
                {
                    orderable: true
                },
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: false},
                {orderable: false},

            ],
            language: {
                emptyTable: "{{ __("common.No data available in the table") }}",
                search: "<i class='ti-search'></i>",
                searchPlaceholder: '{{ __("common.Quick Search") }}',
                paginate: {
                    next: "<i class='ti-arrow-right'></i>",
                    previous: "<i class='ti-arrow-left'></i>"
                }
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i class="far fa-copy"></i>',
                    title: $("#logo_title").val(),
                    titleAttr: '{{__('common.Copy')}}',
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="far fa-file-excel"></i>',
                    titleAttr: '{{__('common.Excel')}}',
                    title: $("#logo_title").val(),
                    margin: [10, 10, 10, 0],
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    },

                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="far fa-file-alt"></i>',
                    titleAttr: '{{__('common.CSV')}}',
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="far fa-file-pdf"></i>',
                    title: $("#logo_title").val(),
                    titleAttr: '{{__('common.PDF')}}',
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    },
                    orientation: 'landscape',
                    pageSize: 'A4',
                    margin: [0, 0, 0, 12],
                    alignment: 'center',
                    header: true,
                    customize: function (doc) {
                        doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    }

                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: '{{__('common.Print')}}',
                    title: $("#logo_title").val(),
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i class="fa fa-columns"></i>',
                    postfixButtons: ['colvisRestore']
                }
            ],
            columnDefs: [{
                visible: false
            }, {responsivePriority: 1, targets: -1},
                {responsivePriority: 2, targets: -2},
            ],
            responsive: true,
            paging: true,
            "lengthChange": true,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
        });
    </script>
@endpush
