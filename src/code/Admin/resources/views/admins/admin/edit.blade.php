@extends('layouts.admin')

@section('title', 'Edit Admin')

@section('content')
	{!! Form::model($record, [
	'url' => route('admin.admins.update', $record->id), 
	'method' => 'PUT', 
	'class' => 'validate',
	'files' => true]) !!}
		@include('admins.admin._form')
	{!! Form::close() !!}
@endsection