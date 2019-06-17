@extends('admin.index')
@section('content')
    @include('admin.school._form', compact('model'))
    {{--Table--}}
    @include('admin.school.list', compact('models'))
@endsection