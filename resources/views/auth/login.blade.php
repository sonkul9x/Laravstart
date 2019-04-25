@extends('layouts.auth')

@section('content')
<div class="login-box">
    <div class="login-logo">
      <a href="#">SK V1.0</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">{{ __('Login') }}</p>
  
        <form action="{{ route('login') }}" method="post">
            @csrf
          <div class="input-group mb-3">
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Email"  value="{{ old('email') }}" required autofocus>
            <div class="input-group-append">
                <span class="fa fa-envelope input-group-text"></span>
            </div>
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>
          <div class="input-group mb-3">
            <input id="password" type="password" placeholder="Password"  class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            <div class="input-group-append">
                <span class="fa fa-lock input-group-text"></span>
            </div>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
          <div class="row">
            <div class="col-8">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Login') }}</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        @if (Route::has('password.request'))
        <p class="mb-1">
          <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
        </p>
        @endif
        <p class="mb-0">
          <a href="{{ route('register') }}" class="text-center">{{ __('Register') }}</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
@endsection
