<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Page Builder</title>
    <link rel="stylesheet"  href="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/bootstrap-3.4.1/css/bootstrap.min.css" data-type="keditor-style" />
    <link rel="stylesheet"  href="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/font-awesome-4.7.0/css/font-awesome.min.css" data-type="keditor-style" />

    <link rel="stylesheet"  href="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/dist/css/keditor.css" data-type="keditor-style" />
    <link rel="stylesheet"  href="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/dist/css/keditor-components.css" data-type="keditor-style" />
    <!-- End of KEditor styles -->
    <link rel="stylesheet"  href="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/code-prettify/src/prettify.css" />
    <link rel="stylesheet"  href="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/css/examples.css" />


    <link rel="stylesheet" type="text/css" data-type="keditor-style"  href="{{ asset('public/frontend/infixlmstheme') }}/css/frontend_style.css">
    <link rel="stylesheet" type="text/css" data-type="keditor-style" href="{{asset('Modules/PageBuilder/Resources/assets/css')}}/style1.css">

</head>

<body>
<div data-keditor="html">

    <div id="content-area">
        {!! $details!!}
    </div>

</div>

@include('backend.partials.script')
<script type="text/javascript" src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/jquery-1.11.3/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/bootstrap-3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/ckeditor-4.11.4/ckeditor.js"></script>
<script type="text/javascript" src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/formBuilder-2.5.3/form-builder.min.js"></script>
<script type="text/javascript" src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/formBuilder-2.5.3/form-render.min.js"></script>
<!-- Start of KEditor scripts -->
<script type="text/javascript" src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/dist/js/keditor.js"></script>
<script type="text/javascript" src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/dist/js/keditor-components.js"></script>
<!-- End of KEditor scripts -->
<script type="text/javascript" src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/code-prettify/src/prettify.js"></script>
<script type="text/javascript" src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/js-beautify-1.7.5/js/lib/beautify.js"></script>
<script type="text/javascript" src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/js-beautify-1.7.5/js/lib/beautify-html.js"></script>
{{--<script type="text/javascript" src="{{url('')}}/keditor/js/examples.js"></script>--}}
<script type="text/javascript" data-keditor="script">
    $(function () {
        $('#content-area').keditor({
            snippetsUrl: '{{route('page_builder.snippet')}}',
            title: 'Design {{$row->title}} Page',
            onSave: function (content) {
                var url = '{{ route("page_builder.pages.design.update",":id") }}';
                url = url.replace(':id', {{$row->id}});
                $.ajax({
                    url: url,
                    type: "PUT",
                    data: {
                        'body': content,
                        _token: "{{csrf_token()}}"
                    },
                    success: function (data) {
                        location.reload();
                        toastr.success('Page Designed Save Successfully')
                    }
                });
            },
        });
    });
</script>
</body>
</html>
