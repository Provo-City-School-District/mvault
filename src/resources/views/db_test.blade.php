<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<body>
	@foreach ($data as $dat)
		<p>{{ $dat->ip_address; }}</p>
	@endforeach
	</body>
</html>