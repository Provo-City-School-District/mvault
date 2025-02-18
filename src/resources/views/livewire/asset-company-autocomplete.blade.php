<div>
    <label for="company">Company:</label>

    <input 
        type="text" 
        id="company" 
        name="company" 
        wire:model.live="query" 
        class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1 w-full"
        placeholder="Search company..."
    >

    @if ($showDropdown)
        <ul class="absolute bg-white border border-gray-300 w-full mt-1 max-h-40 overflow-y-auto shadow-lg rounded z-10">
            @forelse ($companies as $company)
                <li class="p-2 hover:bg-gray-100 cursor-pointer" wire:click="selectCompany('{{ $company['name'] }}')">
                    {{ $company['name'] }}
                </li>
            @empty
                <li class="p-2 text-gray-500">No results found</li>
            @endforelse
        </ul>
    @endif
</div>
