@extends('errors::illustrated-layout')

@section('code', '403')
@section('title', __('Forbidden'))

@section('image')
   <h1>Your account is being blocked by admin. Please contact to Cannabis Admin at support@cannabis.com for more queries. Regards Cannabis Team</h1>
@endsection

@section('message', __($exception->getMessage() ?: 'Sorry, you are forbidden from accessing this page.'))
