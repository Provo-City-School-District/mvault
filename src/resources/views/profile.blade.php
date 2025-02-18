@extends('base')

@section('content')
    <h1 class="text-3xl">Profile</h1>

    Name: {{ $user->name }}<br>
    Email: {{ $user->email }}
@endsection
