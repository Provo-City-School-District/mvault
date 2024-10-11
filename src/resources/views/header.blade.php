<header id="mainHeader">
    <img src="{{ asset('assets/img/pcsd-logo-website-header-160w.png') }}" alt="siteLogo" id="siteLogo">
    @auth
    <nav class="topnav" id="myTopnav">
        <a href=" {{ route('create_asset') }} ">Create Asset</a>
        <a href=" {{ route('all_locations') }} ">Locations</a>
        <a href=" {{ route('search') }} ">Search</a>
        <a href=" {{ route('profile') }} ">Profile</a>
        <a href=" {{ route('logout') }} ">Logout</a>
        <a href="javascript:void(0);" class="icon" onclick="toggleNav()">
            &#9776;
        </a>
    </nav>
    @endauth
</header>
<main id="mainContent">