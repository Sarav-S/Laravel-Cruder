@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
	{!! Form::open([
		'url' => route('admin.users.store'), 
		'method' => 'POST', 
		'class' => 'validate',
		'files' => true]) !!}
		@include('users.admin._form')
	{!! Form::close() !!}
@endsection