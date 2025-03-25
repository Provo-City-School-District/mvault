@extends('base')

@section('content')
@if (session('status'))
    <div>
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="error-container">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-red-500"><strong>{{ $error }}</strong></li>
            @endforeach
        </ul>
    </div>
@endif

<h1 class="text-3xl my-4">Manage User {{ $user->name }}</h1>


<div>
    <form method="POST" action="{{ route('update_user') }}">
        @csrf

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
            <label for="can_create_assets">Can Create Assets? (insert/add assets into app)</label>
            <input type="checkbox" id="can_create_assets" name="can_create_assets" @if ($permissions->can_create_assets) checked @endif>
        </div>
        <div>
            <label for="can_edit_assets">Can Edit Assets? (name/location etc)</label>
            <input type="checkbox" id="can_edit_assets" name="can_edit_assets" @if ($permissions->can_edit_assets) checked @endif>
        </div>
        <div>
            <label for="can_schedule_work">Can Schedule Asset Work? (create/manage scheduled maintenance)</label>
            <input type="checkbox" id="can_schedule_work" name="can_schedule_work" @if ($permissions->can_schedule_work) checked @endif>
        </div>
        <div>
            <label for="can_do_work">Can Do Asset Work? (perform scheduled maintenance)</label>
            <input type="checkbox" id="can_do_work" name="can_do_work" @if ($permissions->can_do_work) checked @endif>
        </div>

        <input type="submit" class="button" value="Update User">
    </form>
</div>

@endsection
