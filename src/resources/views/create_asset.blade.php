@extends('base')

@section('content')
@if (session('status'))
    <div>
        {{ session('status') }}
    </div>
@endif

@if ($errors->has('form_validation'))
<div class="error-container">
    <strong>
        <p class="text-red-500">{{ $errors->first('form_validation') }}</p>
    </strong>
</div>
@endif

<h1 class="text-3xl mb-10">Create Asset</h1>
<form method="POST" action="{{ route('create_asset') }}">
    @csrf

    <div>
        <h2 class="text-2xl">General Information</h2>
        <label for="asset_name">Asset Name:</label>
        <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="asset_name" name="asset_name">
        <label for="category">Category:</label>
        <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5 mb-10" id="category" name="category">
            <option disabled selected value> -- Select a category -- </option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->display_name }}</option>
            @endforeach
        </select>
        <div class="grid grid-cols-4 gap-4 mb-10">
            <label for="serial">Serial:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="serial" name="serial">

            <label for="barcode">Barcode:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="barcode" name="barcode">

            <label for="company">Company:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="company" name="company">

            <label for="model">Model:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="model" name="model">
        </div>

        <h2 class="text-2xl">Location</h2>
        <div class="grid grid-cols-2 gap-4 mb-10">
            <label for="site_number">Site:</label>
            <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5" id="site_number" name="site_number">
                <option disabled selected value> -- Select a location -- </option>
                @foreach ($sites as $site)
                <option value="{{ $site->site_number }}">{{ $site->display_name }}</option>
                @endforeach
            </select>

            <label for="room">Room:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="room" name="room">
        </div>

        <h2 class="text-2xl">Purchasing</h2>
        <div class="grid grid-cols-2 gap-4 mb-10">
            <label for="purchase_price">Asset Price:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="purchase_price" name="purchase_price">

            <label for="purchase_date">Purchase Date:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="date" id="purchase_date" name="purchase_date">

            <label for="projected_eol_date">Projected EOL Date:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="date" id="projected_eol_date" name="projected_eol_date">
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