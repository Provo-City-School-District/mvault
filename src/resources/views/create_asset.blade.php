@extends('base')

@section('content')
<link rel="stylesheet" href="{{url('assets/css/create_asset.css')}}">
<h1>Create Asset</h1>
<form method="POST" action="/create_asset">
    @csrf

    <h3>General Information</h3>
    <div id="information">
        <label for="serial">Serial:</label>
        <input type="text" id="serial" name="serial"><br>

        <label for="barcode">Barcode:</label>
        <input type="text" id="barcode" name="barcode"><br>

        <label for="company">Company:</label>
        <input type="text" id="company" name="company"><br>

        <label for="model">Model:</label>
        <input type="text" id="model" name="model"><br>
    </div>

    <h3>Location</h3>
    <div id="location">
        <label for="site_number">Site:</label>
        <select id="site_number" name="site_number">
        @foreach ($sites as $site)
            <option value="{{ $site->site_number }}">{{ $site->display_name }}</option>
        @endforeach
        </select><br>

        <label for="room">Room:</label>
        <input type="text" id="room" name="room"><br>
    </div>


    <h3>Extra</h3>
    <div id="extra">
        <label for="notes">Additional notes:</label>
        <input type="text" id="notes" name="notes"><br>
    </div>

    <input type="submit" value="Create Asset">
</form>
@endsection