@extends('Store::register.layout')
@section('content')
@include('Store::includes.header')
    {{-- To do --}}
    <div class="tnc-wrap" id="tnc_wrapper">
            {!!$data->content!!}           
    </div>
@endsection