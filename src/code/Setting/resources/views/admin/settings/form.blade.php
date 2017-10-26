@extends('layouts.admin')

@section('title', 'Manage Settings')

@section('breadcrumbs')
    <?php /** {!! Breadcrumbs::render("admin.settings") !!} */ ?>
@endsection

@section("content")
    {!! Form::open(['url' => route('admin.settings.post'), 'method' => 'POST', 'files' => true]) !!}
        @include('partials.errors')
        @include('partials.notifications')
        <?php $settings->each(function($value, $key) { ?>
            <div class="settings-form-wrapper">
            <h3>{{ $key }}</h3>
            {!! renderFormField(collect($value)->sortBy('id')) !!}
            </div>
        <?php }); ?>
        <div class="form-group">
            {!! Form::submit("Update Settings", ['class' => 'btn btn-success']) !!}
        </div>
    {!! Form::close() !!}
@endsection
