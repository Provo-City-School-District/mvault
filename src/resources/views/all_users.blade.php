@extends('base')

@section('content')
    <h1>All Users</h1>
    <table id="usersTable">
        <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Is Admin</th>
                <th>Can Create Assets</th>
                <th>Can Edit Assets</th>
                <th>Can Schedule Work</th>
                <th>Can Do Work</th>
                <th>Last Login</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td><a href="{{ route('manage_user', ['id' => $user->id]) }}">{{ $user->email }}</a></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->permissions->admin ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->permissions->can_create_assets ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->permissions->can_edit_assets ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->permissions->can_schedule_work ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->permissions->can_do_work ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->last_login }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @livewire('allowed-users')
@endsection
@section('config')
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                pageLength: 10
            });
        });
    </script>
@endsection
test
