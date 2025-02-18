<div>
    @if (session()->has('error'))
        <div class="text-red-500 px-4 py-2 mb-4">
            {{ session('error') }}
        </div>
    @endif
    @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
    <h1 class="text-3xl my-4">All Companies</h1>
    <table class="shadow-lg bg-white border-collapse">
        <thead>
            <tr>
                <th class="bg-blue-100 border px-8 py-4">Company Name</th>
                <th class="bg-blue-100 border px-8 py-4">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($companies as $company)
                <tr class="hover:bg-gray-50">
                    <td class="border px-8 py-4">{{ $company->name }}</td>
                    <td class="border px-8 py-4">
                        <button wire:click="removeCompany({{ $company->id }})" class="bg-red-500 text-white px-2 py-1 rounded">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h1 class="text-3xl my-4">Add Company</h1>
    <div class="grid-cols-2">
        <div><input type="text" wire:model="name" class="border px-4 py-2" placeholder="Company Name"></div>
        <div><button wire:click="addCompany" class="bg-green-500 text-white px-4 py-2 rounded">Add</button></div>
    </div>
</div>