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

<form method="POST" action="{{ route('update_asset') }}"> 
    @csrf
    
    <input type="hidden" name="id" value="{{ $asset->id }}">
    <div class="asset-container">

        <h1>Edit Asset '{{ $asset->name }}'</h1>
        <h2>General Information</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
            <div class="grid grid-cols-4 gap-4">
                <label for="asset_name">Asset Name:</label>
                <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text" id="asset_name" name="asset_name" value="{{ $asset->name }}">
                
                <label for="barcode">Barcode:</label>
                <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text" id="barcode" name="barcode" value="{{ $asset->barcode }}">
                
                <label for="category">Category:</label>
                <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5 mb-10 col-span-3 p-1" id="category" name="category">
                    <option disabled value> -- Select a category -- </option>
                    @foreach ($categories as $category)
                        @if ($category->id == $asset->category)
                            <option value="{{ $category->id }}" selected>{{ $category->display_name }}</option>
                        @else
                            <option value="{{ $category->id }}">{{ $category->display_name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-4 gap-4">
                <label for="serial">Serial:</label>
                <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text" id="serial" name="serial" value="{{ $asset->serial }}">

                <label for="company">Company:</label>
                <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text" id="company" name="company" value="{{ $asset->company }}">

                <label for="model">Model:</label>
                <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text" id="model" name="model" value="{{ $asset->model }}">
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4 mb-10">
            {{-- second column  --}}
        </div>


        <h2>Location</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
            <div class="grid grid-cols-4 gap-4 mb-10">
                <label for="site_number">Site:</label>
                <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5 col-span-3" id="site_number" name="site_number">
                    @foreach ($sites as $site)
                        @if ($site->id == $asset->site)
                            <option value="{{ $site->site_number }}" selected>{{ $site->display_name }}</option>
                        @else
                            <option value="{{ $site->site_number }}">{{ $site->display_name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-4 gap-4 mb-10">
                <label for="room">Room:</label>
                <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3" type="text" id="room" name="room" value="{{ $asset->room }}">
            </div>
        </div>


        <h2>Purchasing</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                <div class="grid grid-cols-4 gap-4 mb-10">
                    <label for="purchase_price">Asset Price:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3" type="number" id="purchase_price" name="purchase_price" value="{{ $asset->purchase_price }}">

                    <label for="purchase_date">Purchase Date:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3" type="date" id="purchase_date" name="purchase_date" value="{{ $asset->purchase_date }}">

                    <label for="projected_eol_date">Projected EOL Date:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3" type="date" id="projected_eol_date" name="projected_eol_date" value="{{ $asset->projected_eol_date }}">
                </div>

                <div class="grid grid-cols-4 gap-4 mb-10">
                    <p>Last validated:</p> {{ $asset->last_validated }}
                </div>
            </div>


        <h2>Extra</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                <div class="grid grid-cols-4 gap-4 mb-10">
                    <label for="notes">Description:</label>
                    <textarea class="bg-gray-200 text-gray-700 border border-black rounded min-h-[200px] p-3 col-span-3" type="text" id="description" name="description">{{ $asset->description }}</textarea>
                </div>
                
                <div class="grid grid-cols-4 gap-4 mb-10">
                    <h3>Work Done</h3>
                </div>
            </div>
            

  
            
            <input type="submit" class="button" value="Update Asset">

    </div>
</form>
@endsection