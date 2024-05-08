@extends('base')

@section('content')
<h1>The Safe</h1>
<a href=" {{ route('search') }} ">Search Assets</a>
<a href=" {{ route('profile') }} ">Profile</a>
<a href=" {{ route('logout') }} ">Logout</a>
@endsection
