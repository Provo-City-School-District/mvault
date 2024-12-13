@extends('base')

@section('content')
<h1 class="text-3xl mb-10">Assets at {{ $location_name }}</h1>

<table class="shadow-lg bg-white border-collapse">
    <thead>
        <tr>
            <th class="bg-blue-100 border px-8 py-4">Serial</th>
            <th class="bg-blue-100 border px-8 py-4">Barcode</th>
            <th class="bg-blue-100 border px-8 py-4">Model</th>
        </tr>
    </thead>

    <tbody>
    @foreach ($assets as $asset)
    <tr class="hover:bg-gray-50">
        <td class="border px-8 py-4"><a href="{{ route('edit_asset', ['asset' => $asset->id]) }}">{{ $asset->serial }}</a></td>
        <td class="border px-8 py-4">{{ $asset->barcode }}</td>
        <td class="border px-8 py-4">{{ $asset->model }}</td>
    </tr>
    @endforeach
    </tbody>
</table>

@endsection