@extends('base')

@section('content')
<h1>Create Asset</h1>
<form method="POST" action="/create_asset">
    @csrf
    <label for="asset_name">Asset name:</label>
    <input type="text" id="asset_name" name="asset_name"><br>

    <label for="site">Site:</label>
    <select id="site" name="site">
    @foreach ($sites as $site)
        <option value="{{ $site->site_number }}">{{ $site->display_name }}</option>
    @endforeach
    </select><br>
    <input type="submit" value="Create Asset">
</form>
@endsection