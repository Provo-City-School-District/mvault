<!DOCTYPE html>
<html lang="en">

<head>
    <title>Maintenance Vault</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>

<body>
    @include('header')

    <main id="mainContent">
    @yield('content')
    </main>

    @include('footer')
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>