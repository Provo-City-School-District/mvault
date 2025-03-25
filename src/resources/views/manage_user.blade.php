@extends('base')

@section('content')
<h1 class="text-3xl my-4">Manage User {{ $user->name }}</h1>


<div>
    <form method="POST" action="{{ route('update_user') }}">
        <input type="hidden" name="id" value="{{ $user->id }}">
        <p>ID: {{ $user->id }}</p>
        <div>
            <label for="name">Name:</label>
            <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text" name="name" type="text" value="{{ $user->name }}">
        </div>
        <div>
            <label for="is_admin">Is Admin - Can Add/Manage Users, EOL Assets</label>
            <input type="checkbox" id="is_admin" name="is_admin" @if ($permissions->admin) checked @endif>
        </div>
        <div>
            <label for="can_edit_assets">Can Edit Assets? (name/location etc)</label>
            <input type="checkbox" id="can_edit_assets" name="can_edit_assets" @if ($permissions->can_edit_assets) checked @endif>
        </div>
    </form>
</div>

@endsection
