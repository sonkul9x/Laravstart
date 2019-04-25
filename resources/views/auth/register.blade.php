@extends('layouts.auth')

@section('content')
<div class="register-box">
    <div class="register-logo">
      <a href="#">SK V1.0</a>
    </div>
  
    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Đăng ký tài khoản sử dụng hệ thống</p>
  
        <form action="{{ route('register') }}" method="post">
            @csrf
          <div class="input-group mb-3">
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"  placeholder="Full name" name="name" value="{{ old('name') }}" required autofocus>
            <div class="input-group-append">
                <span class="fa fa-user input-group-text"></span>
            </div>
            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
          </div>
          <div class="input-group mb-3">
            <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
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
            <input id="password" placeholder="Password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            <div class="input-group-append">
                <span class="fa fa-lock input-group-text"></span>
            </div>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
          <div class="input-group mb-3">
            <input id="password-confirm" type="password" placeholder="Retype password" class="form-control" name="password_confirmation" required>
            <div class="input-group-append">
                <span class="fa fa-lock input-group-text"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
                    <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Register') }}</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        </div>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
@endsection
