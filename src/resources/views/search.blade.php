@extends('base')

@section('content')
<h1>Search (all assets for now)</h1>

<table>
    <tr>
        <th>Asset Name</th>
        <th>Asset Location</th>
    </tr>

    @foreach ($assets as $asset)
    <tr>
        <td>{{ $asset['name'] }}</td>
        <td>{{ $asset['site_name'] }}</td>
    </tr>
    @endforeach
</table>
@endsection