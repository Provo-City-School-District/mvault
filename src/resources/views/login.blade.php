<!DOCTYPE html>
<html lang="en">

<head>
    <title>Maintenance Vault</title>
    <link rel="stylesheet" href="{{ asset('assets/css/reset.css') }}?v={{ env('ASSET_VERSION') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/variables-common.css') }}?v={{ env('ASSET_VERSION') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/typography.css') }}?v={{ env('ASSET_VERSION') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}?v={{ env('ASSET_VERSION') }}">
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}?v={{ env('ASSET_VERSION') }}">
</head>
@include('header')

<body>
    @if ($errors->has('login'))
    <div id="login-error-container">
        <strong>
            {{ $errors->first('login') }}
        </strong>
    </div>
    @endif

    <div id="login-wrapper">
        <h1>Login to Mvault</h1>
        <a href="{{ route('google.redirect') }}" class="button">Login with Google</a>
        <p>This system is intended for authorized users only. Any login attempts will be stored.</p>
    </div>
    @include('footer')
</body>

</html>