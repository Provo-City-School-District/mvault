@extends('base')

@section('content')
<h1>All Locations</h1>
<ul class="grid3">
    @foreach ($location_list as $loc)
    <li><a href="{{ route('location_assets', ['location' => $loc['site_number']]) }} ">{{ $loc['display_name'] }}</a></li>
    @endforeach
</ul>
@endsection