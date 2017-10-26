@extends('layouts.admin')

@section('title', 'Add Admin')

@section('content')
	{!! Form::open([
	'url' => route('admin.admins.store'), 
	'method' => 'POST', 
	'class' => 'validate', 
	'files' => true]) !!}
		@include('admins.admin._form')
	{!! Form::close() !!}
@endsection