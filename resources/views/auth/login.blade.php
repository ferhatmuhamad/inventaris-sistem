@extends('layouts.loginpage')

@section('style-custom')
<link rel="stylesheet" href="{{asset("assets/login/fonts/icomoon/style.css")}}">

<link rel="stylesheet" href="{{asset("assets/login/css/owl.carousel.min.css")}}">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{asset("assets/login/css/bootstrap.min.css")}}">

<!-- Style -->
<link rel="stylesheet" href="{{asset("assets/login/css/style.css")}}">
@endsection

@section('content')
<div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url({{asset("assets/img/futake.jpeg")}});"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-8">
            <h1><strong>Futake Indonesia</strong></h1>
            <h3>Login to <strong>SISFO Inventaris Barang</strong></h3>
            <p class="mb-4"></p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group first">
                    <label for="email">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Anda@gmail.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group last mb-3">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password Anda">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-flex mb-5 align-items-center">
                    <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <div class="control__indicator"></div>
                    </label>
                    {{-- <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> --}}
                    @if (Route::has('password.request'))
                    <span class="ml-auto">
                        <a class="forgot-pass" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </span>
                    @endif
                </div>

                <button type="submit" class="btn btn-block btn-primary">
                    {{ __('Login') }}
                </button>
            </form>
            <div class="mt-3">
                <span><a href="#" style="
                font-family: 'Raleway', sans-serif;
                font-size: 14px;
                font-weight: 600;
                font-style: normal;
                font-stretch: normal;
                line-height: 1.11;
                letter-spacing: normal;
                text-align: left;
                text-decoration: none;
                color: #037bfe;">Belum punya hak akses?</a>
                </span>
                <br>
                <span style="
                font-family: 'Raleway', sans-serif;
                font-size: 12px;
                font-weight: 600;
                font-style: normal;
                font-stretch: normal;
                line-height: 1.11;
                letter-spacing: normal;
                text-align: left;
                color: #37392e;">
                Silakan hubungi admin kantor untuk mendapatkan hak akses </span>

            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
@endsection

@section('script-custom')
<script src="{{asset("assets/login/js/jquery-3.3.1.min.js")}}"></script>
<script src="{{asset("assets/login/js/popper.min.js")}}"></script>
<script src="{{asset("assets/login/js/bootstrap.min.js")}}"></script>
<script src="{{asset("assets/login/js/main.js")}}"></script>
@endsection
