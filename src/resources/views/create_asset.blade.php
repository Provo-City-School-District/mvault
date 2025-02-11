@extends('base')

@section('content')
    @if (session('status'))
        <div>
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error-container">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-red-500"><strong>{{ $error }}</strong></li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1>Create Asset</h1>
    <form method="POST" action="{{ route('create_asset') }}">
        @csrf
        <div>
            <h2>General Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                <div class="grid grid-cols-4 gap-4">
                    <label for="asset_name">Asset Name:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                        id="asset_name" name="asset_name" value="{{ old('asset_name') }}">
                    <label for="barcode">Barcode:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                            id="barcode" name="barcode" value="{{ old('barcode') }}">
                    <label for="category">Category:</label>
                    <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5 mb-10 col-span-3 p-1"
                        id="category" name="category">
                        <option disabled selected value> -- Select a category -- </option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category') == $category->id)>{{ $category->display_name }}</option>
                        @endforeach
                    </select>
                   
                </div>
                <div class="grid grid-cols-4 gap-4">
                    <label for="serial">Serial:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                        id="serial" name="serial" value="{{ old('serial') }}">

                    <label for="company">Company:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                        id="company" name="company" value="{{ old('company') }}">

                    <label for="model">Model:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                        id="model" name="model" value="{{ old('model') }}">
                </div>
            </div>


            <h2>Location</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                <div class="grid grid-cols-4 gap-4">
                    <label for="site_number">Site:</label>
                    <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5 col-span-3 p-1" id="site_number"
                        name="site_number">
                        <option disabled selected value> -- Select a location -- </option>
                        @foreach ($sites as $site)
                            <option value="{{ $site->site_number }}" @selected(old('site_number') == $site->site_number)>{{ $site->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-4 gap-4">
                    <label for="room">Room:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                        id="room" name="room" value="{{ old('room') }}">
                </div>
            </div>


            <h2>Purchasing</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                <div class="grid grid-cols-4 gap-4">
                    <label for="purchase_price">Asset Price:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                        id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}">
                    <label for="purchase_date">Purchase Date:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="date"
                        id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                    <label for="projected_eol_date">Projected Asset Lifetime:</label>
                    <div class="flex">
                        <input class="bg-gray-200 text-gray-700 border border-black rounded p-1" type="number"
                            id="projected_lifetime" name="projected_lifetime" value="{{ old('projected_lifetime') }}">
                        <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5"
                            id="projected_lifetime_units" name="projected_lifetime_units">
                            <option value="years">Years</option>
                            <option value="months">Months</option>
                            <option value="days">Days</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2">
                   
                </div>
            </div>


            <h2>Extra</h2>
            <div class="grid gap-4 mb-10">
                <label for="notes">Description:</label>
                <textarea class="bg-gray-200 text-gray-700 border border-black rounded min-h-[200px] p-3" type="text"
                    id="description" name="description">{{ old('description') }}</textarea>
            </div>

            <input type="submit" class="button" value="Create Asset">
        </div>
    </form>
@endsection
