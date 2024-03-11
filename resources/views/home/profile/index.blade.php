@extends('home.parent')

@section('content')

    Ini halaman profile
    {{Auth::user()->name }}

@endsection