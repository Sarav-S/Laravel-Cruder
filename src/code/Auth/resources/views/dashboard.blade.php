@extends('layouts.app')

@section('content')
	<h2>User Logged In</h2>
	<a href="{{ route('user.profile') }}">@lang('messages.profile_information')</a>
	<form action="{{ route('logout') }}" method="POST">
		{{ csrf_field() }}
		<button type="submit">@lang('messages.logout')</button>
	</form>
@endsection