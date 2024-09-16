<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Maintenance Vault</title>
        <link rel="stylesheet" href="{{url('assets/css/app.css')}}">
    </head>
    <body> 
    <h1>Login</h1>
    @if ($errors->has('login'))
    <div id="login-error-container">
        <strong>
        {{ $errors->first('login') }}
        </strong>
    </div>
    @endif

    <a href="{{ route('google.redirect') }}" class="btn btn-primary">Login with Google</a>
    @include('footer')
    </body>
</html>
