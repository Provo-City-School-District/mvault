<!DOCTYPE html>
<html lang="en">

<head>
    <title>Maintenance Vault</title>
    <link rel="stylesheet" href="{{ asset('assets/css/variables-common.css') }}?v={{ env('ASSET_VERSION') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.css') }}?v={{ env('ASSET_VERSION') }}">
</head>
<body>
    @include('header')

    <main id="mainContent" class="p-6">
        @yield('content')
    </main>

    @include('footer')
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('script')
    @livewireScripts
</body>
</html>
