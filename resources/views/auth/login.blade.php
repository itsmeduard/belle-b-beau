<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Belle n Beau') }}</title>

    <link rel="icon" type="image/png" sizes="180x180" href="{{ asset('panelAssets/img/circle-cropped.png')}}">
    <link rel="stylesheet" href="{{ asset('panelAssets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('panelAssets/fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('panelAssets/fonts/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('panelAssets/fonts/fontawesome5-overrides.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="{{ asset('panelAssets/css/Login-Form-Clean.css') }}">
    <link rel="stylesheet" href="{{ asset('panelAssets/css/styles.css') }}">
</head>

<body>
<div class="login-clean">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h2 class="sr-only">Login Form</h2>
        <div class="illustration"><img class="img-fluid" src="{{ asset('panelAssets/img/bnbms_logo_2.png') }}" alt="Belle N Beau"></div>
        <div class="form-group">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit">{{ __('Login') }}</button>
        </div>
{{--        @if (Route::has('password.request'))--}}
{{--            <a class="forgot" href="{{ route('password.request') }}">--}}
{{--                {{ __('Forgot Your Password?') }}--}}
{{--            </a>--}}
{{--        @endif--}}
    </form>
</div>
<script src="{{ asset('panelAssets/js/jquery.min.js') }}"></script>
<script src="{{ asset('panelAssets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('panelAssets/js/bs-init.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
</body>

</html>
