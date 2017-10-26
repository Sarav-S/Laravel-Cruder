@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
	{!! Form::model($record, [
		'url' => route('admin.users.update', $record->id), 
		'method' => 'PUT', 
		'class' => 'validate',
		'files' => true]) !!}
		@include('users.admin._form')
	{!! Form::close() !!}
@endsection