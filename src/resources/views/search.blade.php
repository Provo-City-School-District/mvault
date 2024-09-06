@extends('base')

@section('content')
<h1>Search (all assets for now)</h1>

<table>
    <tr>
        <th>Serial</th>
        <th>Barcode</th>
        <th>Name</th>
        <th>Location</th>
    </tr>

    @foreach ($assets as $asset)
    <tr>
        <td>{{ $asset->serial }}</td>
        <td>{{ $asset->barcode }}</td>
        <td>{{ $asset->model }}</td>
        <td>{{ $asset->site_name}} | {{ $asset->room }}</td>
    </tr>
    @endforeach
</table>
@endsection