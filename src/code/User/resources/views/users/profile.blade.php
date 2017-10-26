@extends('layouts.app')

@section('content')
	{!! Form::model(user(), [
	'route' => 'user.profile', 
	'method' => 'PUT', 
	'class' => 'validate',
	'files' => true
	]) !!}
	@include('partials.errors')
	@include('partials.notifications')
	<div class="form-group">
		{!! Form::label('name', __('messages.Name')) !!}
		{!! Form::text(
				'name', 
				null, 
				[
					'class'    => 'form-control', 
					'id'       => 'name',
					'required' => 'required'
				]
			) 
		!!}
	</div>
	<div class="form-group">
		{!! Form::label('email', __('messages.E-Mail Address')) !!}
		{!! Form::input(
				'email',
				'email', 
				null, 
				[
					'class'    => 'form-control', 
					'id'       => 'email',
					'required' => 'required'
				]
			) 
		!!}
		<p class="help-block">@lang('messages.Please enter valid email address.')</p>
	</div>
	<div class="form-group">
		{!! Form::label('password', __('messages.Password')) !!}
		{!! Form::input(
				'password', 
				'password', 
				null, 
				[
					'class'    => 'form-control', 
					'id'       => 'password',
				]
			) 
		!!}
		<p class="help-block">
			@lang('messages.While setting password keep strong password with alphanumeric values min of 8 characters.')
		</p>
	</div>
	<div class="form-group">
		<a href="" class="block">
			<img src="{{ user()->image }}" alt="{{ user()->image }}" width="50px">
		</a>
		{!! Form::label('file', __('messages.Image')) !!}
		{!! Form::file('image') !!}
		<p class="help-block">
			@lang('messages.Please upload only valid image')
		</p>
	</div>
	<div class="form-group">
		<button class="btn btn-green">
			<span>@lang('messages.Update Profile Information')</span>
		</button>
	</div>
	{!! Form::close() !!}
@endsection