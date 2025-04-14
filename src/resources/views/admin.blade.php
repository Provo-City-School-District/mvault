@extends('base')

@section('content')
    <h1 class="text-3xl">Admin</h1>

    <ul>
        <li><a href="{{ route('asset_companies') }}">Manage Companies</a></li>
        <li><a href="{{ route('all_users') }}">Manage Users</a></li>
    </ul>

    <h2 class="text-2xl my-4">Changelog</h2>

    <table id="logsTable" class="table-auto border-collapse border border-gray-400 w-full">
        <thead>
            <tr>
                <th class="border border-gray-400 px-4 py-2">Date</th>
                <th class="border border-gray-400 px-4 py-2">User</th>
                <th class="border border-gray-400 px-4 py-2">Action</th>
                <th class="border border-gray-400 px-4 py-2">Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td class="border border-gray-400 px-4 py-2" style="width: 10%;">{{ $log->created_at }}</td>
                    <td class="border border-gray-400 px-4 py-2" style="width: 15%;">{{ $log->user->name ?? 'System' }}</td>
                    <td class="border border-gray-400 px-4 py-2" style="width: 20%;">{{ $log->action }}</td>
                    <td class="border border-gray-400 px-4 py-2">
                        @php
                            $details = json_decode($log->details, true); // Decode JSON into an array
                        @endphp
                        @if (is_array($details))
                            <ul class="list-disc pl-4">
                                @if (isset($details['user_id']))
                                    <li><strong>User:</strong>
                                        <a href="{{ env('APP_DOMAIN') }}/manage_user/{{ $details['user_id'] }}"
                                            class="text-blue-500 underline">
                                            {{ $details['user_id'] }}
                                        </a>
                                    </li>
                                @endif
                                @if (isset($details['asset_id']))
                                    <li><strong>Asset:</strong>
                                        <a href="{{ env('APP_DOMAIN') }}/edit_asset/{{ $details['asset_id'] }}"
                                            class="text-blue-500 underline">
                                            {{ $details['asset_id'] }}
                                        </a>
                                    </li>
                                @endif
                                @foreach ($details as $key => $value)
                                    @if (!in_array($key, ['user_id', 'asset_id']))
                                        <!-- Skip user_id and asset_id -->
                                        @if (is_array($value))
                                            <li><strong>{{ ucfirst($key) }}</strong>:
                                                <ul class="list-disc pl-4">
                                                    @foreach ($value as $subKey => $subValue)
                                                        <li>{{ ucfirst($subKey) }}:
                                                            @if (is_array($subValue))
                                                                Original:
                                                                {{ $subValue['original'] === true || $subValue['original'] === 1 ? 'Yes' : ($subValue['original'] === false || $subValue['original'] === 0 ? 'No' : $subValue['original']) }},
                                                                Updated:
                                                                {{ $subValue['updated'] === true || $subValue['updated'] === 1 ? 'Yes' : ($subValue['updated'] === false || $subValue['updated'] === 0 ? 'No' : $subValue['updated']) }}
                                                            @else
                                                                {{ $subValue === true || $subValue === 1 ? 'Yes' : ($subValue === false || $subValue === 0 ? 'No' : $subValue) }}
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <li><strong>{{ ucfirst($key) }}</strong>:
                                                {{ $value === true || $value === 1 ? 'Yes' : ($value === false || $value === 0 ? 'No' : $value) }}
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <p>{{ $log->details }}</p> <!-- Fallback for non-JSON or plain text -->
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('config')
    <script>
        $(document).ready(function() {
            $('#logsTable').DataTable({
                pageLength: 10,
                order: [
                    [0, 'desc']
                ],
            });
        });
    </script>
@endsection
