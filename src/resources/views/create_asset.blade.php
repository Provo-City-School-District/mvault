@extends('base')

@section('content')
<h1>Create Asset</h1>
<form method="POST" action="/create_asset">
    @csrf
    <label for="asset_name">Asset name:</label><br>
    <input type="text" id="asset_name" name="asset_name"><br>

    <input type="submit" value="Create Asset">
</form>
@endsection