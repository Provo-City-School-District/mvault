<!DOCTYPE html>
<html lang="en">

<head>
    <title>Maintenance Vault</title>
    <link rel="stylesheet" href="{{url('assets/css/app.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/login.css')}}">
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
        <p>This system is intended for authorized users only. Any attempts will be logged.</p>
    </div>
    @include('footer')
</body>

</html>