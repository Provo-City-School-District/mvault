@extends('base')

@section('content')
<h1 class="text-3xl">Profile</h1>

Name: {{ $name }}<br>
Email: {{ $email }}
@endsection