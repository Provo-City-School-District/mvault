@extends('base')

@section('content')
@foreach ($errors->all() as $error)
  <div class="error-container">{{ $error }}</div>
@endforeach
<h1>Search Results</h1>
<table>
    <tr>
        <th>Location</th>
        <th>Serial</th>
        <th>Barcode</th>
        <th>Model</th>
    </tr>
    @foreach ($assets as $asset)
    <tr>
        <td>{{ $asset->location_str }}</td>
        <td><a href="{{ route('edit_asset', ['asset' => $asset->id]) }}">{{ $asset->serial }}</a></td>
        <td>{{ $asset->barcode }}</td>
        <td>{{ $asset->model }}</td>
    </tr>
    @endforeach
</table>
@endsection