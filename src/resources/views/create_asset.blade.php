@extends('base')

@section('content')
<link rel="stylesheet" href="{{url('assets/css/create_asset.css')}}">
<h1>Create Asset</h1>
<form method="POST" action="/create_asset">
    @csrf


    <div id="information">
        <h2>General Information</h2>
        <label for="serial">Serial:</label>
        <input type="text" id="serial" name="serial">

        <label for="barcode">Barcode:</label>
        <input type="text" id="barcode" name="barcode">

        <label for="company">Company:</label>
        <input type="text" id="company" name="company">

        <label for="model">Model:</label>
        <input type="text" id="model" name="model">

        <label for="category">Category:</label>
        <input type="text" id="category" name="category">
    </div>


    <div id="location">
        <h2>Location</h2>
        <label for="site_number">Site:</label>
        <select id="site_number" name="site_number">
            @foreach ($sites as $site)
            <option value="{{ $site->site_number }}">{{ $site->display_name }}</option>
            @endforeach
        </select>

        <label for="room">Room:</label>
        <input type="text" id="room" name="room">
    </div>

    <div id="purchasing">
        <h2>Purchasing</h2>
        <label for="program">Program:</label>
        <input type="text" id="program" name="program">

        <label for="purchase_date">Purchase Date:</label>
        <input type="date" id="purchase_date" name="purchase_date">

        <label for="expected_lifespan">Expected Lifespan:</label>
        <input type="number" id="expected_lifespan" name="expected_lifespan">
    </div>

    <div id="extra">
        <h2>Extra</h2>
        <label for="notes">Additional notes:</label>
        <input type="text" id="notes" name="notes">
    </div>

    <input type="submit" class="button" value="Create Asset">
</form>
@endsection