<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="{{url('assets/css/app.css')}}">
    </head>
    <body>
        <h1>The Safe</h1>
        <a href=" {{ route('search') }} ">Search Assets</a>
        <a href=" {{ route('profile') }} ">Profile</a>
        <a href=" {{ route('logout') }} ">Logout</a>
    </body>
</html>