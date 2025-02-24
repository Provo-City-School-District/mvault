@extends('base')

@section('content')
    <h1 class="text-3xl mb-10">Assets at {{ $location_name }}</h1>

    <table class="shadow-lg bg-white border-collapse">
        <thead>
            <tr>
                <th class="bg-blue-100 border px-8 py-4">Name</th>
                <th class="bg-blue-100 border px-8 py-4">Room</th>
                <th class="bg-blue-100 border px-8 py-4">Serial</th>
                <th class="bg-blue-100 border px-8 py-4">Barcode</th>
                <th class="bg-blue-100 border px-8 py-4">Company</th>
                <th class="bg-blue-100 border px-8 py-4">Model</th>
                <th class="bg-blue-100 border px-8 py-4">Category</th>
                <th class="bg-blue-100 border px-8 py-4">Purchase Date</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($assets as $asset)
                <tr class="hover:bg-gray-50">
                    <td class="border px-8 py-4"><a
                            href="{{ route('edit_asset', ['asset_id' => $asset->id]) }}">{{ $asset->name }}</a></td>
                    <td class="border px-8 py-4">{{ $asset->room }}</td>
                    <td class="border px-8 py-4">{{ $asset->serial }}</td>
                    <td class="border px-8 py-4">{{ $asset->barcode }}</td>
                    <td class="border px-8 py-4">{{ $asset->company_name }}</td>
                    <td class="border px-8 py-4">{{ $asset->model }}</td>
                    <td class="border px-8 py-4">{{ $asset->category_name }}</td>
                    <td class="border px-8 py-4">{{ $asset->purchase_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
