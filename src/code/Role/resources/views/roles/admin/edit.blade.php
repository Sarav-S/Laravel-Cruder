@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')
	
	{!! Form::model($record, ['url' => route('admin.roles.update', $record->id), 'method' => 'PUT', 'class' => 'validate']) !!}
		@include('roles.admin._form')
	{!! Form::close() !!}
@endsection