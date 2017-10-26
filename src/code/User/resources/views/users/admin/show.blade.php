@extends('layouts.admin')

@section('title', 'View User')

@section('content')
    <div class="col-sm-6">
        @foreach(collect($record)->except(['deleted_at'])->toArray() as $title=>$value)
        <div class="form-group">
            <label for="">{{ preg_replace('/([a-z])([A-Z])/s','$1 $2', studly_case($title)) }}</label>
            <p>{{ $value }}</p>
        </div>
        @endforeach
    </div>
@endsection