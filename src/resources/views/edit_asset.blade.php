@extends('base')

@section('content')
@if (session('status'))
    <div>
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('update_asset') }}"> 
    @csrf
    <input type="hidden" name="id" value="{{ $asset->id }}">
    <div class="asset-container">
        <h2 class="text-2xl">General Information</h2>
        <label for="asset_name">Asset Name:</label>
        <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="asset_name" name="asset_name" value="{{ $asset->name }}">
        <label for="category">Category:</label>
        <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5 mb-10" id="category" name="category">
            <option disabled value> -- Select a category -- </option>
            @foreach ($categories as $category)
                @if ($category->id == $asset->category)
                    <option value="{{ $category->id }}" selected>{{ $category->display_name }}</option>
                @else
                    <option value="{{ $category->id }}">{{ $category->display_name }}</option>
                @endif
            @endforeach
        </select>
        <div class="grid grid-cols-4 gap-4 mb-10">
            <label for="serial">Serial:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="serial" name="serial" value="{{ $asset->serial }}">

            <label for="barcode">Barcode:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="barcode" name="barcode" value="{{ $asset->barcode }}">

            <label for="company">Company:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="company" name="company" value="{{ $asset->company }}">

            <label for="model">Model:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="model" name="model" value="{{ $asset->model }}">
        </div>

        <h2 class="text-2xl">Location</h2>
        <div class="grid grid-cols-4 gap-4 mb-10">
            <label for="site_number">Site:</label>
            <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5" id="site_number" name="site_number">
                @foreach ($sites as $site)
                    @if ($site->id == $asset->site)
                        <option value="{{ $site->site_number }}" selected>{{ $site->display_name }}</option>
                    @else
                        <option value="{{ $site->site_number }}">{{ $site->display_name }}</option>
                    @endif
                @endforeach
            </select>

            <label for="room">Room:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="room" name="room" value="{{ $asset->room }}">
        </div>

        <h2 class="text-2xl">Purchasing</h2>
        <div class="grid grid-cols-4 gap-4 mb-10">
            <label for="purchase_price">Asset Price:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="number" id="purchase_price" name="purchase_price" value="{{ $asset->purchase_price }}">

            <label for="purchase_date">Purchase Date:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="date" id="purchase_date" name="purchase_date" value="{{ $asset->purchase_date }}">

            <label for="projected_eol_date">Projected EOL Date:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="date" id="projected_eol_date" name="projected_eol_date" value="{{ $asset->projected_eol_date }}">
        </div>

        <h2 class="text-2xl">Extra</h2>
        <div class="grid grid-cols-4 gap-4 mb-10">
            <label for="notes">Additional notes:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="notes" name="notes" value="{{ $asset->notes }}">
        </div>

        <div id="inventory">
            <p>Last validated:</p> {{ $asset->last_validated }}
            <input type="submit" class="button" value="Update Asset">
        </div>
    </div>
</form>
@endsection