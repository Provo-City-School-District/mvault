@extends('base')

@section('content')
@foreach ($errors->all() as $error)

  <div class="error-container">{{ $error }}</div>

@endforeach
<h1>Search</h1>
<form method="POST" action="/search">
    @csrf
    <div>
        <label for="search_by">Search By:</label>
        <select id="search_by" name="search_by">
            <option value="barcode_serial">Barcode/Serial</option>
            <option value="barcode">Barcode</option>
            <option value="serial">Serial</option>
            <option value="location">Location</option>
        </select>

        <label for="search_query">Barcode/Serial:</label>
        <input type="text" id="search_query" name="search_query">
    </div>
    <input type="submit" class="button" value="Search">
</form>
@endsection