@extends('base')

@section('content')
<link rel="stylesheet" href="{{ url('assets/css/create_asset.css') }}">
<h1 class="text-3xl mb-10">Create Asset</h1>
<form method="POST" action="{{ route('create_asset') }}">
    @csrf

    <div>
        <h2 class="text-2xl">General Information</h2>
        <div class="grid grid-cols-4 gap-4 mb-10">
            <label for="serial">Serial:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="serial" name="serial">

            <label for="barcode">Barcode:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="barcode" name="barcode">

            <label for="company">Company:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="company" name="company">

            <label for="model">Model:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="model" name="model">

            <label for="category">Category:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="category" name="category">
        </div>

        <h2 class="text-2xl">Location</h2>
        <div class="grid grid-cols-2 gap-4 mb-10">
            <label for="site_number">Site:</label>
            <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5" id="site_number" name="site_number">
                @foreach ($sites as $site)
                <option value="{{ $site->site_number }}">{{ $site->display_name }}</option>
                @endforeach
            </select>

            <label for="room">Room:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="room" name="room">
        </div>

        <h2 class="text-2xl">Purchasing</h2>
        <div class="grid grid-cols-2 gap-4 mb-10">
            <label for="program">Program:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="program" name="program">

            <label for="purchase_date">Purchase Date:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="date" id="purchase_date" name="purchase_date">

            <label for="expected_lifespan">Expected Lifespan:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="number" id="expected_lifespan" name="expected_lifespan">
        </div>

        <h2 class="text-2xl">Extra</h2>
        <div class="grid grid-cols-2 gap-4 mb-10">
            <label for="notes">Additional notes:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="notes" name="notes">
        </div>

        <input type="submit" class="button" value="Create Asset">
    </div>
</form>
@endsection