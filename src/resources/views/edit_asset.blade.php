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

    <form method="POST" action="{{ route('update_asset') }}">
        @csrf

        <input type="hidden" name="id" value="{{ $asset->id }}">
        <div class="asset-container">

            <h1>Edit Asset '{{ $asset->name }}'</h1>
            <h2>General Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                <div class="grid grid-cols-4 gap-4">
                    <label for="asset_name">Asset Name:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                        id="asset_name" name="asset_name" value="{{ $asset->name }}"
                        @if (!$permissions->admin && !$permissions->can_edit_assets) readonly @endif>

                    <label for="barcode">Barcode:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                        id="barcode" name="barcode" value="{{ $asset->barcode }}"
                        @if (!$permissions->admin && !$permissions->can_edit_assets) readonly @endif>

                    <label for="category">Category:</label>
                    <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5 mb-10 col-span-3"
                        id="category" name="category" @if (!$permissions->admin && !$permissions->can_edit_assets) disabled @endif>
                        <option disabled value> -- Select a category -- </option>
                        @foreach ($categories as $category)
                            @if ($category->id == $asset->category)
                                <option value="{{ $category->id }}" selected>{{ $category->display_name }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->display_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-4 gap-4">
                    <label for="serial">Serial:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                        id="serial" name="serial" value="{{ $asset->serial }}"
                        @if (!$permissions->admin && !$permissions->can_edit_assets) readonly @endif>

                    @if (!$permissions->admin && !$permissions->can_edit_assets)
                        <label for="company">Company:</label>
                        <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                            id="company" name="company"
                            value="{{ App\Models\AssetCompany::where('id', $asset->company)->first()->name }}" readonly>
                    @else
                        @livewire('asset-company-autocomplete', ['defaultValue' => $asset->company])
                    @endif
                    <label for="model">Model:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3 p-1" type="text"
                        id="model" name="model" value="{{ $asset->model }}"
                        @if (!$permissions->admin && !$permissions->can_edit_assets) readonly @endif>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-4 mb-10">
                {{-- second column  --}}
            </div>


            <h2>Location</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                <div class="grid grid-cols-4 gap-4 mb-10">
                    <label for="site_number">Site:</label>
                    <select class="bg-gray-200 text-gray-700 border text-sm rounded-lg p-2.5 col-span-3" id="site_number"
                        name="site_number" @if (!$permissions->admin && !$permissions->can_edit_assets) disabled @endif>
                        @foreach ($sites as $site)
                            @if ($site->id == $asset->site)
                                <option value="{{ $site->site_number }}" selected>{{ $site->display_name }}</option>
                            @else
                                <option value="{{ $site->site_number }}">{{ $site->display_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-4 gap-4 mb-10">
                    <label for="room">Room:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3" type="text"
                        id="room" name="room" value="{{ $asset->room }}"
                        @if (!$permissions->admin && !$permissions->can_edit_assets) readonly @endif>
                </div>
            </div>



            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                <div class="grid grid-cols-4 gap-4 mb-10">
                    <h2 class="col-span-full">Purchasing</h2>
                    <label for="purchase_price">Purchase Price:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3" type="number"
                        id="purchase_price" name="purchase_price" value="{{ $asset->purchase_price }}"
                        @if (!$permissions->admin && !$permissions->can_edit_assets) readonly @endif>

                    <label for="purchase_date">Purchase Date:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3" type="date"
                        id="purchase_date" name="purchase_date" value="{{ $asset->purchase_date }}"
                        @if (!$permissions->admin && !$permissions->can_edit_assets) readonly @endif>

                    <label for="projected_eol_date">Projected EOL Date:</label>
                    <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-3" type="date"
                        id="projected_eol_date" name="projected_eol_date" value="{{ $asset->projected_eol_date }}"
                        @if (!$permissions->admin && !$permissions->can_edit_assets) readonly @endif>
                </div>

                <div class="grid grid-cols-4 gap-4 mb-10">
                    <h2>Extra</h2>
                    <label for="notes" class="col-span-full">Description:</label>
                    <textarea class="bg-gray-200 text-gray-700 border border-black rounded min-h-[100px] p-3 col-span-full" type="text"
                        id="description" name="description" @if (!$permissions->admin && !$permissions->can_edit_assets) readonly @endif>{{ $asset->description }}</textarea>
                </div>
            </div>

            <input type="submit" class="button" value="Update Asset">

        </div>
    </form>
    {{-- <p>Last validated:</p> {{ $asset->last_validated }} --}}

    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-10">

        <div class="grid col-span-1 place-self-start">
            <h2 class="col-span-full">Add Work</h2>
            <form method="POST" action="{{ route('work_done.store', $asset->id) }}" class="grid grid-cols-6 gap-4">
                @csrf
                <label for="work_description" class="col-span-full">Description of Work:</label>
                <textarea class="bg-gray-200 text-gray-700 border border-black rounded min-h-[100px] p-3 col-span-full"
                    id="work_description" name="description" @if (!$permissions->admin && !$permissions->can_do_work) readonly @endif></textarea>

                <label for="work_date" class="col-span-2">Date of work:</label>
                <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-4" type="date"
                    id="work_date" name="date" @if (!$permissions->admin && !$permissions->can_do_work) readonly @endif>

                <label for="ticket_id" class="col-span-2">Ticket Number:</label>
                <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-4" type="number"
                    id="ticket_id" name="ticket_id" @if (!$permissions->admin && !$permissions->can_do_work) readonly @endif>

                <input type="submit" class="button col-span-full max-w-fit" value="Add Work Done">
            </form>
        </div>

        <div class="grid col-span-3 place-self-start w-full">
            <h2 class="col-span-full">Previous Work</h2>
            <table id="prevWork" class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2">Date</th>
                        <th class="py-2">Description</th>
                        <th class="py-2">By</th>
                        <th class="py-2">Ticket</th>
                        <th class="py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asset->workDone as $work)
                        <tr>
                            <td class="border px-4 py-2">{{ $work->date }}</td>
                            <td class="border px-4 py-2">{{ $work->description }}</td>
                            <td class="border px-4 py-2">{{ $work->user->name }}</td>
                            <td class="border px-4 py-2"><a
                                    href="{{ env('HELP_URL') }}/controllers/tickets/edit_ticket.php?id={{ $work->ticket_id }}">{{ $work->ticket_id }}</a>
                            </td>
                            <td class="border px-4 py-2">{{ $work->ticket_status }}</td>
                        </tr>
                    @endforeach
            </table>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-10">
        <div class="grid col-span-1 place-self-start">
            <h2 class="col-span-full">Schedule Preventative Maintenance</h2>
            <form method="POST" action="{{ route('maintenance.schedule', $asset->id) }}"
                class="grid grid-cols-6 gap-4">
                @csrf
                <label for="maintenance_description" class="col-span-full">Description of Maintenance:</label>
                <textarea class="bg-gray-200 text-gray-700 border border-black rounded min-h-[100px] p-3 col-span-full"
                    id="maintenance_description" name="description" @if (!$permissions->admin && !$permissions->can_schedule_work) readonly @endif></textarea>

                <label for="maintenance_date" class="col-span-2">Date of Maintenance:</label>
                <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-4" type="date"
                    id="maintenance_date" name="date" @if (!$permissions->admin && !$permissions->can_schedule_work) readonly @endif>

                <label for="maintenance_interval" class="col-span-2">Interval (days):</label>
                <input class="bg-gray-200 text-gray-700 border border-black rounded col-span-4" type="number"
                    id="maintenance_interval" name="interval" @if (!$permissions->admin && !$permissions->can_schedule_work) readonly @endif>
                <input type="submit" class="button col-span-full max-w-fit" value="Schedule Maintenance">
            </form>
        </div>

        <div class="grid col-span-3 place-self-start w-full">
            <h2 class="col-span-full">Scheduled Maintenance</h2>
            <table id='schedWork' class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2">Prior Completed</th>
                        <th class="py-2">Intervals (days)</th>
                        <th class="py-2">Next Date</th>
                        <th class="py-2">Description</th>
                        <th class="py-2">Scheduled By</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asset->scheduledMaintenance as $maintenance)
                        <tr>
                            <td class="border px-4 py-2">{{ $maintenance->date }}</td>
                            <td class="border px-4 py-2">{{ $maintenance->interval }}</td>
                            <td class="border px-4 py-2">{{ $maintenance->nextDate() }}</td>
                            <td class="border px-4 py-2">{{ $maintenance->description }}</td>
                            <td class="border px-4 py-2">{{ $maintenance->user->name }}</td>
                            <td class="border px-4 py-2">
                                <form method="POST" action="{{ route('maintenance.delete', $maintenance->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button text-white">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if ($permissions->admin)
        @if (!$asset->eol)
            <form method="POST" action="{{ route('edit_asset.eol') }}" class="grid grid-cols-6 gap-4"
                onsubmit="return confirm('Are you sure you want to EOL this asset?');">
                @csrf
                <input type="hidden" name="id" value="{{ $asset->id }}">
                <input type="submit" class="button col-span-full max-w-fit" value="End-of-Life Asset">
            </form>
        @elseif ($permissions->admin)
            <form method="POST" action="{{ route('edit_asset.un-eol') }}" class="grid grid-cols-6 gap-4"
                onsubmit="return confirm('Are you sure you want to undo EOL?');">
                @csrf
                <input type="hidden" name="id" value="{{ $asset->id }}">
                <input type="submit" class="button col-span-full max-w-fit" value="Undo End-of-Life Asset">
            </form>
        @endif
    @endif
@endsection
@section('config')
    <script>
        $(document).ready(function() {
            $('#prevWork').DataTable({
                pageLength: 10
            });
        });
        $(document).ready(function() {
            $('#schedWork').DataTable({
                pageLength: 10
            });
        })
    </script>
@endsection
