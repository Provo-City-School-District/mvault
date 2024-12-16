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
        <div class="grid grid-cols-4 gap-4 mb-10">
            <label for="serial">Serial:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="serial" name="serial" value="{{ $asset->serial }}">

            <label for="barcode">Barcode:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="barcode" name="barcode" value="{{ $asset->barcode }}">

            <label for="company">Company:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="company" name="company" value="{{ $asset->company }}">

            <label for="model">Model:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="model" name="model" value="{{ $asset->model }}">

            <label for="category">Category:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="category" name="category" value="{{ $asset->category }}">
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
            <label for="program">Program:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="program" name="program" value="{{ $asset->program }}">

            <label for="purchase_date">Purchase Date:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="date" id="purchase_date" name="purchase_date" value="{{ $asset->purchase_date }}">

            <label for="expected_lifespan">Expected Lifespan:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded" type="number" id="expected_lifespan" name="expected_lifespan" value="{{ $asset->expected_lifespan }}">
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