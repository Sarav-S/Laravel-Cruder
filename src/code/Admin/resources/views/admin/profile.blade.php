@extends('layouts.admin')

@section('title', 'Profile Information')

@section('content')
	{!! Form::model(admin(), ['route' => 'admin.profile', 
	'method' => 'PUT', 
	'class' => 'validate', 
	'files' => true]) !!}
	@include('partials.errors')
	@include('partials.notifications')
	<div class="form-group">
		{!! Form::label('name', 'Name') !!}
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
		{!! Form::label('email', 'Email Address') !!}
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
		<p class="help-block">Please enter valid email address.</p>
	</div>
	<div class="form-group">
		{!! Form::label('password', 'Password') !!}
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
		<p class="help-block">While setting password keep strong password with alphanumeric values min of 8 characters.</p>
	</div>
	<div class="form-group">
		<a href="{{ asset(admin()->image) }}" target="_blank" class="block">
			<img src="{{ asset(admin()->image) }}" alt="{{ admin()->image }}" width="50px">
		</a>
		{!! Form::label('image', 'Image') !!}
		{!! Form::file('image') !!}
		<p class="help-block">Please upload valid images</p>
	</div>
	<div class="form-group">
		<button class="btn btn-success">
			<span>Update Profile Information</span>
		</button>
	</div>
	{!! Form::close() !!}
@endsection