<x-admin-layout title="Dashboard">
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $cards = [
                ['label' => 'Total Activities', 'value' => $stats['activities'], 'tone' => 'bg-parish-50 text-parish-700'],
                ['label' => 'Upcoming', 'value' => $stats['upcoming'], 'tone' => 'bg-emerald-50 text-emerald-700'],
                ['label' => 'Registrations', 'value' => $stats['registrations'], 'tone' => 'bg-amber-50 text-amber-700'],
                ['label' => 'Announcements', 'value' => $stats['announcements'], 'tone' => 'bg-sky-50 text-sky-700'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">{{ $card['label'] }}</p>
                <p class="mt-2 text-3xl font-extrabold {{ $card['tone'] }} inline-block rounded-lg px-2 -ml-2">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <h2 class="font-bold text-slate-900">Recent registrations</h2>
                <a href="{{ route('admin.registrations.index') }}" class="text-sm font-semibold text-parish-700 hover:text-parish-600">View all</a>
            </div>
            @if ($recentRegistrations->isEmpty())
                <p class="px-5 py-8 text-center text-sm text-slate-500">No registrations yet.</p>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentRegistrations as $registration)
                        <li class="flex items-center justify-between gap-4 px-5 py-3">
                            <div class="min-w-0">
                                <p class="truncate font-medium text-slate-800">{{ $registration->name }}</p>
                                <p class="truncate text-sm text-slate-500">{{ $registration->activity?->title }}</p>
                            </div>
                            <time class="shrink-0 text-xs text-slate-400">{{ $registration->created_at->diffForHumans() }}</time>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <h2 class="font-bold text-slate-900">Next activities</h2>
                <a href="{{ route('admin.activities.index') }}" class="text-sm font-semibold text-parish-700 hover:text-parish-600">Manage</a>
            </div>
            @if ($nextActivities->isEmpty())
                <p class="px-5 py-8 text-center text-sm text-slate-500">No upcoming activities.</p>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($nextActivities as $activity)
                        <li class="flex items-center justify-between gap-4 px-5 py-3">
                            <div class="min-w-0">
                                <p class="truncate font-medium text-slate-800">{{ $activity->title }}</p>
                                <p class="truncate text-sm text-slate-500">{{ $activity->starts_at->format('M j, Y g:i A') }}</p>
                            </div>
                            <a href="{{ route('admin.activities.edit', $activity) }}" class="shrink-0 text-sm font-semibold text-parish-700 hover:text-parish-600">Edit</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-admin-layout>
