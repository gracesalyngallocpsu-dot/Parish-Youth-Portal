<x-admin-layout title="Activities">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <form method="GET" class="flex w-full max-w-sm items-center gap-2">
            <x-text-input name="q" type="text" placeholder="Search activities..." class="block w-full" :value="request('q')" />
            <x-secondary-button type="submit">Search</x-secondary-button>
        </form>

        <a href="{{ route('admin.activities.create') }}" class="inline-flex items-center justify-center rounded-lg bg-parish-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-parish-800">
            + New activity
        </a>
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Activity</th>
                        <th class="px-5 py-3">Schedule</th>
                        <th class="px-5 py-3">Registrations</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($activities as $activity)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-800">{{ $activity->title }}</div>
                                @if ($activity->location)
                                    <div class="text-slate-500">{{ $activity->location }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-slate-600">
                                {{ $activity->starts_at->format('M j, Y') }}
                                <div class="text-xs text-slate-400">{{ $activity->starts_at->format('g:i A') }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ $activity->registrations_count }}</span>
                            </td>
                            <td class="px-5 py-4">
                                @if ($activity->is_published)
                                    <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">Published</span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">Draft</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('activities.show', $activity) }}" target="_blank" class="font-semibold text-slate-500 hover:text-slate-700">View</a>
                                    <a href="{{ route('admin.activities.edit', $activity) }}" class="font-semibold text-parish-700 hover:text-parish-600">Edit</a>
                                    <form method="POST" action="{{ route('admin.activities.destroy', $activity) }}"
                                          onsubmit="return confirm('Delete this activity and all its registrations?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-semibold text-red-600 hover:text-red-500">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-500">No activities found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $activities->links() }}
    </div>
</x-admin-layout>
