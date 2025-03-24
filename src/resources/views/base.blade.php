<!DOCTYPE html>
<html lang="en">

<head>
    <title>Maintenance Vault</title>
    <link rel="stylesheet" href="{{ asset('assets/css/variables-common.css') }}?v={{ env('ASSET_VERSION') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.css') }}?v={{ env('ASSET_VERSION') }}">
    <link rel="stylesheet" href="{{ asset('assets/DataTables/datatables.min.css') }}?v={{ env('ASSET_VERSION') }}">
</head>

<body>
    @include('header')

    <main id="mainContent" class="p-6">
        @yield('content')
    </main>

    @include('footer')
    <script src="{{ asset('assets/js/main.js') }}?v={{ env('ASSET_VERSION') }}"></script>
    <script src="{{ asset('assets/DataTables/datatables.min.js') }}?v={{ env('ASSET_VERSION') }}"></script>
    @yield('script')
    @livewireScripts
    @livewireStyles
</body>
@yield('config')

</html>
