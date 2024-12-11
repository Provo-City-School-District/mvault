@extends('base')

@section('content')
<h1>Asset {{ $asset->model }}</h1>
<pre>{{ print_r($asset) }}</pre>

@endsection