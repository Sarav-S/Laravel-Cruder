@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
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

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">@lang('messages.Password')</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" required name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ __('messages.'.$errors->first('password')) }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('messages.Remember Me')
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                @lang('messages.Login')
                            </button>

                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                @lang('messages.Forgot Your Password')?
                            </a>
                        </div>
                    </div>
                    <br/>
                    <hr>
                    <br/>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            Don't have account already? &nbsp; &nbsp;
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                Create One
                            </a>
                        </div>
                        <div class="col-md-6 col-md-offset-4">
                            <a href="{{ url('/social/auth/redirect', ['facebook']) }}" class="btn btn-primary">        Facebook Login
                            </a>
                        </div>
                        <div class="col-md-6 col-md-offset-4">
                            <a href="{{ url('/social/auth/redirect', ['google']) }}" class="btn btn-primary">
                                Google Login
                            </a>
                        </div>
                        <div class="col-md-6 col-md-offset-4">
                            <a href="{{ url('/social/auth/redirect', ['twitter']) }}" class="btn btn-primary">
                                Twitter Login
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
