@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{$row->title}}
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('Modules/PageBuilder/Resources/assets/css')}}/style1.css">
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/frontend_style.css">

@endsection

@section('mainContent')

    {!! $details??'' !!}
@endsection

@section('js') @endsection
