@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('twitter.email.post') }}">
                    {{ csrf_field() }}
                    @if (count($errors))
                        <ul class="error-messages alert alert-danger">
                            @foreach($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">@lang('messages.E-Mail Address')</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" required value="{{ old('email') }}" autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ __('messages.'.$errors->first('email')) }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">
                            
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
