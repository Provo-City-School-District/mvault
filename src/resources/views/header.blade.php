<header id="mainHeader">
    <img src="{{ asset('assets/img/pcsd-logo-website-header-160w.png') }}" alt="siteLogo" id="siteLogo">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}?v={{ env('ASSET_VERSION') }}">
    @auth
        <nav class="topnav" id="myTopnav">
            {{-- Admins can see all menu items --}}
            @if (Auth::user()->permissions->admin || Auth::user()->permissions->can_create_assets)
                <a href="{{ route('create_asset') }}" class="{{ request()->is('create_asset') ? 'active' : '' }}">Create
                    Asset</a>
            @endif
            <a href="{{ route('all_locations') }}"
                class="{{ request()->is('all_locations') ? 'active' : '' }}">Locations</a>
            <div class="dropdown">
                <a href="{{ route('search') }}"
                    class="dropbtn {{ request()->is('search') || request()->is('search_eol') ? 'active' : '' }}">Search</a>
                <div class="dropdown-content" style="left:0;">
                    <a href="{{ route('search') }}">Search</a>
                    <a href="{{ route('search_eol') }}">Search EOL</a>
                </div>
            </div>
            <a href="{{ route('profile') }}" class="{{ request()->is('profile') ? 'active' : '' }}">Profile</a>
            @if (Auth::user()->permissions->admin)
                <a href="{{ route('admin') }}" class="{{ request()->is('admin') ? 'active' : '' }}">Admin</a>
            @endif
            <a href="{{ route('logout') }}">Logout</a>
            <a href="javascript:void(0);" class="icon" onclick="toggleNav()">
                &#9776;
            </a>
        </nav>
    @endauth
</header>
