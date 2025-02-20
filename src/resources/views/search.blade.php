@extends('base')

@section('content')
    @foreach ($errors->all() as $error)
        <div class="error-container">{{ $error }}</div>
    @endforeach
    @if ($search_by_eol)
        <h1 class="text-3xl">Search (EOL)</h1>
    @else
        <h1 class="text-3xl">Search</h1>
    @endif
    <form id="search-form" method="POST" action={{ route('search.form') }}>
        @csrf
        @if ($search_by_eol)
            <input type="hidden" name="is_eol" value="true">
        @endif
        <div>
            <div class="mb-3">
                <label for="search_by">Search By:</label>
                <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5" id="search_by" name="search_by">
                    <option value="name">Name</option>
                    <option value="barcode_serial">Barcode/Serial</option>
                    <option value="barcode">Barcode</option>
                    <option value="serial">Serial</option>
                    <option value="location">Location</option>
                </select>
            </div>
            <div>
                <label for="search_query">Query:</label>
                <input class="bg-gray-200 text-gray-700 border border-black rounded" type="text" id="search_query"
                    name="search_query">
            </div>
        </div>
        <input type="submit" class="button" value="Search">
    </form>
@endsection
