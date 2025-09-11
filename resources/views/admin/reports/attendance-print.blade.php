<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none;
            }

            @page {
                size: A4;
                margin: 12mm;
            }
        }
    </style>
    <link rel="icon" href="data:,">
    <meta name="robots" content="noindex">
    <meta name="color-scheme" content="light only">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="referrer" content="no-referrer">
</head>

<body class="bg-white text-gray-900">
    <div class="max-w-5xl mx-auto p-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold">Attendance Report</h1>
                <p class="text-sm text-gray-500">Generated: {{ now()->format('Y-m-d H:i') }}</p>
            </div>
            <div class="no-print">
                <button onclick="window.print()" class="px-4 py-2 rounded bg-gray-900 text-white text-sm">Print / Save
                    PDF</button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm mb-4">
            <div><span class="text-gray-500">Start:</span> {{ $filters['start_date'] ?? '—' }}</div>
            <div><span class="text-gray-500">End:</span> {{ $filters['end_date'] ?? '—' }}</div>
            <div><span class="text-gray-500">Status:</span>
                {{ $filters['status'] ? ucfirst($filters['status']) : 'All' }}</div>
        </div>

        <div class="border rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Member</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Occurrence</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Checked In</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Updated</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($attendances as $idx => $attendance)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $idx + 1 }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                {{ optional($attendance->user)->full_name ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                {{ optional(optional($attendance->event_occurrence)->event)->event_name ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">#{{ $attendance->event_occurrence_id }}</td>
                            <td class="px-4 py-2 text-sm">{{ ucfirst($attendance->status) }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $attendance->formatted_check_in_time }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500">{{ $attendance->formatted_created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>