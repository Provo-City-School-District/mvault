<header id="mainHeader">
    <img src="{{ asset('assets/img/pcsd-logo-website-header-160w.png') }}" alt="siteLogo" id="siteLogo">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}?v={{ env('ASSET_VERSION') }}">
    @auth
        <nav class="topnav" id="myTopnav">
            <a href="{{ route('create_asset') }}" class="{{ request()->is('create_asset') ? 'active' : '' }}">Create Asset</a>
            <a href="{{ route('all_locations') }}" class="{{ request()->is('all_locations') ? 'active' : '' }}">Locations</a>
            <div class="dropdown">
                <a href="{{ route('search') }}" class="dropbtn {{ request()->is('search') || request()->is('search_eol') ? 'active' : '' }}">Search</a>
                <div class="dropdown-content" style="left:0;">
                    <a href="{{ route('search_eol') }}">Search EOL</a>
                </div>
            </div>
            <a href="{{ route('profile') }}" class="{{ request()->is('profile') ? 'active' : '' }}">Profile</a>
            <a href="{{ route('admin') }}" class="{{ request()->is('active') ? 'active' : '' }}">Admin</a>
            <a href="{{ route('logout') }}">Logout</a>
            <a href="javascript:void(0);" class="icon" onclick="toggleNav()">
                &#9776;
            </a>
        </nav>
    @endauth
</header>
