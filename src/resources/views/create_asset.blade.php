@extends('base')

@section('content')
<link rel="stylesheet" href="{{url('assets/css/create_asset.css')}}">
<h1>Create Asset</h1>
<form method="POST" action="/create_asset">
    @csrf

    <h2>General Information</h2>
    <div id="information">
        <label for="serial">Serial:</label>
        <input type="text" id="serial" name="serial">

        <label for="barcode">Barcode:</label>
        <input type="text" id="barcode" name="barcode">

        <label for="company">Company:</label>
        <input type="text" id="company" name="company">

        <label for="model">Model:</label>
        <input type="text" id="model" name="model">
    </div>

    <h2>Location</h2>
    <div id="location">
        <label for="site_number">Site:</label>
        <select id="site_number" name="site_number">
            @foreach ($sites as $site)
            <option value="{{ $site->site_number }}">{{ $site->display_name }}</option>
            @endforeach
        </select>

        <label for="room">Room:</label>
        <input type="text" id="room" name="room">
    </div>


    <h2>Extra</h2>
    <div id="extra">
        <label for="notes">Additional notes:</label>
        <input type="text" id="notes" name="notes">
    </div>

    <input type="submit" class="button" value="Create Asset">
</form>
@endsection