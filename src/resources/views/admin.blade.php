@extends('base')

@section('content')
<h1 class="text-3xl">Admin</h1>

<ul>
    <li><a href="{{ route("asset_companies") }}">Manage Companies</a></li>
    <li><a href="{{ route("all_users") }}">Manage Users</a></li>
</ul>
@endsection
