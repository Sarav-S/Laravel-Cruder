@extends('layouts.admin')

@section('title', 'Add Role')

@section('content')
	
	{!! Form::open(['url' => route('admin.roles.store'), 'method' => 'POST', 'class' => 'validate']) !!}
		@include('roles.admin._form')
	{!! Form::close() !!}
@endsection