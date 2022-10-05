@extends(theme('layouts.master'))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules\Appointment\Resources\assets\frontend\css\appointment.css') }}" />
 
@endsection
@section('mainContent')
    <x-appointment :pages="$pages" :categories="$categories" />
@endsection

