<div class="col-span-4 grid grid-cols-4 gap-1">
    <label for="company">Company:</label>

    <input type="text" id="company" name="company" wire:model.live="query"
        class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" placeholder="Search company...">

    @if ($showDropdown)
        <ul
            class="bg-white border border-gray-300 -mt-1 max-h-40 overflow-y-auto shadow-lg rounded z-10 col-span-3 col-start-2">
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
