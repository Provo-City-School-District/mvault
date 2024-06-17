@extends('base')

@section('content')
<h1>All Locations</h1>
@foreach ($location_list as $loc)
<div>
    <a href="{{ route('location_assets', ['location' => $loc['site_number']]) }} ">{{ $loc['display_name'] }}</a>
</div>
@endforeach
@endsection