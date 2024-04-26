@extends('layouts.Urls')
@section('content')

        @include('layouts.nav')
        @include('layouts.sidebar')

                @yield('body')

@endsection