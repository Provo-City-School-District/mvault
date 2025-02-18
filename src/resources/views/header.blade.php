<header id="mainHeader">
    <img src="{{ asset('assets/img/pcsd-logo-website-header-160w.png') }}" alt="siteLogo" id="siteLogo">
    @auth
        <nav class="topnav" id="myTopnav">
            <a href="{{ route('create_asset') }}" class="{{ request()->is('create_asset') ? 'active' : '' }}">Create Asset</a>
            <a href="{{ route('all_locations') }}" class="{{ request()->is('all_locations') ? 'active' : '' }}">Locations</a>
            <a href="{{ route('search') }}" class="{{ request()->is('search') ? 'active' : '' }}">Search</a>
            <a href="{{ route('profile') }}" class="{{ request()->is('profile') ? 'active' : '' }}">Profile</a>
            <a href="{{ route('admin') }}" class="{{ request()->is('active') ? 'active' : '' }}">Admin</a>
            <a href="{{ route('logout') }}">Logout</a>
            <a href="javascript:void(0);" class="icon" onclick="toggleNav()">
                &#9776;
            </a>
        </nav>
    @endauth
</header>
