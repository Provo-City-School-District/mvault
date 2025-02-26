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
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                        id="asset_name" name="asset_name" value="{{ $asset->name }}">

                    <label for="barcode">Barcode:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                        id="barcode" name="barcode" value="{{ $asset->barcode }}">

                    <label for="category">Category:</label>
                    <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5 mb-10 col-span-3"
                        id="category" name="category">
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
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                        id="serial" name="serial" value="{{ $asset->serial }}">

                    @livewire('asset-company-autocomplete', ['defaultValue' => $asset->company])

                    <label for="model">Model:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                        id="model" name="model" value="{{ $asset->model }}">
                </div>
            </div>

            <div class="grid grid-cols-4 gap-4 mb-10">
                {{-- second column  --}}
            </div>


            <h2>Location</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                <div class="grid grid-cols-4 gap-4 mb-10">
                    <label for="site_number">Site:</label>
                    <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5 col-span-3" id="site_number"
                        name="site_number">
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
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3" type="text"
                        id="room" name="room" value="{{ $asset->room }}">
                </div>
            </div>



            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                <div class="grid grid-cols-4 gap-4 mb-10">
                    <h2 class="col-span-full">Purchasing</h2>
                    <label for="purchase_price">Purchase Price:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3" type="number"
                        id="purchase_price" name="purchase_price" value="{{ $asset->purchase_price }}">

                    <label for="purchase_date">Purchase Date:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3" type="date"
                        id="purchase_date" name="purchase_date" value="{{ $asset->purchase_date }}">

                    <label for="projected_eol_date">Projected EOL Date:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3" type="date"
                        id="projected_eol_date" name="projected_eol_date" value="{{ $asset->projected_eol_date }}">
                </div>

                <div class="grid grid-cols-4 gap-4 mb-10">
                    <h2>Extra</h2>
                    <label for="notes" class="col-span-full">Description:</label>
                    <textarea class="bg-gray-200 text-gray-700 border border-black rounded min-h-[100px] p-3 col-span-full" type="text"
                        id="description" name="description">{{ $asset->description }}</textarea>
                </div>
            </div>

            <input type="submit" class="button" value="Update Asset">

        </div>
    </form>
    <p>Last validated:</p> {{ $asset->last_validated }}

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">

        <div class="grid">
            <h2 class="col-span-full">Add Work</h2>
            <form method="POST" action="{{ route('work_done.store', $asset->id) }}" class="grid grid-cols-6 gap-4">
                @csrf
                <label for="work_description" class="col-span-full">Description of Work:</label>
                <textarea class="bg-gray-200 text-gray-700 border border-black rounded min-h-[100px] p-3 col-span-full"
                    id="work_description" name="description"></textarea>

                <label for="work_date" class="col-span-2">Date of work:</label>
                <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-4" type="date"
                    id="work_date" name="date">

                <label for="ticket_id" class="col-span-2">Ticket Number:</label>
                <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-4" type="number"
                    id="ticket_id" name="ticket_id">

                <input type="submit" class="button col-span-full max-w-fit" value="Add Work Done">
            </form>
        </div>

        <div>
            <h2 class="col-span-full">Previous Work</h2>
            <ul>
                @foreach ($asset->workDone as $work)
                    <li>{{ $work->date }}: {{ $work->description }} by {{ $work->user->name }} in ticket
                        {{ $work->ticket_id }}</li>
                @endforeach
            </ul>
        </div>

    </div>
@endsection
