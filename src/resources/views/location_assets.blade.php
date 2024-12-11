@extends('base')

@section('content')
<h1>Assets at {{ $location_name }}</h1>

<table>
    <tr>
        <th>Serial</th>
        <th>Barcode</th>
        <th>Model</th>
    </tr>

    @foreach ($assets as $asset)
    <tr>
        <td><a href="{{ route('edit_asset', ['asset' => $asset->id]) }}">{{ $asset->serial }}</a></td>
        <td>{{ $asset->barcode }}</td>
        <td>{{ $asset->model }}</td>
    </tr>
    @endforeach
</table>

@endsection