@extends('base')

@section('content')
<h1 class="text-3xl my-4">All Locations</h1>
<ul class="grid grid-cols-3 gap-4">
    @foreach ($location_list as $loc)
    <li><a href="{{ route('location_assets', ['location' => $loc['site_number']]) }} ">{{ $loc['display_name'] }}</a></li>
    @endforeach
</ul>
@endsection