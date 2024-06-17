@extends('base')

@section('content')
<h1>Assets at {{ $location_name }}</h1>

<table>
    <tr>
        <th>Asset Name</th>
    </tr>

    @foreach ($assets as $asset)
    <tr>
        <td>{{ $asset['model'] }}</td>
    </tr>
    @endforeach
</table>

@endsection