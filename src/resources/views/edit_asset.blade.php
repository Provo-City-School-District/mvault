@extends('base')

@section('content')
@if (session('status'))
    <div>
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('update_asset') }}"> 
    @csrf
    <input type="hidden" name="id" value={{ $asset->id }}>
    <div class="asset-container">
        <div id="information">
            <h2>General Information</h2>
            <label for="serial">Serial:</label>
            <input type="text" id="serial" name="serial" value={{ $asset->serial }}>

            <label for="barcode">Barcode:</label>
            <input type="text" id="barcode" name="barcode" value={{ $asset->barcode }}>

            <label for="company">Company:</label>
            <input type="text" id="company" name="company" value={{ $asset->company }}>

            <label for="model">Model:</label>
            <input type="text" id="model" name="model" value={{ $asset->model }}>

            <label for="category">Category:</label>
            <input type="text" id="category" name="category" value={{ $asset->category }}>
        </div>


        <div id="location">
            <h2>Location</h2>
            <label for="site_number">Site:</label>
            <select id="site_number" name="site_number">
                @foreach ($sites as $site)
                    @if ($site->id == $asset->site)
                        <option value="{{ $site->site_number }}" selected>{{ $site->display_name }}</option>
                    @else
                        <option value="{{ $site->site_number }}">{{ $site->display_name }}</option>
                    @endif
                @endforeach
            </select>

            <label for="room">Room:</label>
            <input type="text" id="room" name="room" value={{ $asset->room }}>
        </div>

        <div id="purchasing">
            <h2>Purchasing</h2>
            <label for="program">Program:</label>
            <input type="text" id="program" name="program" value={{ $asset->program }}>

            <label for="purchase_date">Purchase Date:</label>
            <input type="date" id="purchase_date" name="purchase_date" value={{ $asset->purchase_date }}>

            <label for="expected_lifespan">Expected Lifespan:</label>
            <input type="number" id="expected_lifespan" name="expected_lifespan" value={{ $asset->expected_lifespan }}>
        </div>

        <div id="extra">
            <h2>Extra</h2>
            <label for="notes">Additional notes:</label>
            <input type="text" id="notes" name="notes" value={{ $asset->notes }}>
        </div>

        <input type="submit" class="button" value="Update Asset">
    </div>
</form>
@endsection