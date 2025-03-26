<div>
    @if (session()->has('error'))
        <div class="text-red-500 px-4 py-2 mb-4">
            {{ session('error') }}
        </div>
    @endif
    @error('name')
        <span class="text-red-500">{{ $message }}</span>
    @enderror
    <h2 class="text-3xl my-4">Add User</h1>
    <div>
        <div><input type="text" wire:model="username" class="border px-4 py-2" placeholder="username (no @provo.edu)"></div>
        <div class="mt-2"><button wire:click="addUser" class="bg-green-500 text-white px-4 py-2 rounded">Add</button></div>
    </div>
    <h1 class="text-3xl my-4">All Users</h1>
    <table id="userTable" class="shadow-lg bg-white border-collapse">
        <thead>
            <tr>
                <th class="bg-blue-100 border px-8 py-4">Username</th>
                <th class="bg-blue-100 border px-8 py-4">Manage</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($usernames as $username)
                <tr class="hover:bg-gray-50">
                    <td class="border px-8 py-4">{{ $username }}</td>
                    <td class="border px-8 py-4">
                        <button wire:click="removeUser('{{ $username }}')"
                            class="bg-red-500 text-white px-2 py-1 rounded">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


</div>
