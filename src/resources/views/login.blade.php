@extends('base')

@section('content')
<h1>Login</h1>
<a href="{{ route('google.redirect') }}" class="btn btn-primary">Login with Google</a>
@endsection