<x-admin-layout title="Registrations">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div>
                <x-input-label for="activity" value="Filter by activity" />
                <select id="activity" name="activity" onchange="this.form.submit()"
                        class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-parish-500 focus:ring-parish-500">
                    <option value="">All activities</option>
                    @foreach ($activities as $activity)
                        <option value="{{ $activity->id }}" @selected((string) $activityId === (string) $activity->id)>{{ $activity->title }}</option>
                    @endforeach
                </select>
            </div>
            <noscript><x-secondary-button type="submit">Apply</x-secondary-button></noscript>
        </form>

        <a href="{{ route('admin.registrations.export', array_filter(['activity' => $activityId])) }}"
           class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700">
            Export CSV
        </a>
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Name</th>
                        <th class="px-5 py-3">Activity</th>
                        <th class="px-5 py-3">Contact</th>
                        <th class="px-5 py-3">Registered</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($registrations as $registration)
                        <tr class="hover:bg-slate-50 align-top">
                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-800">{{ $registration->name }}</div>
                                @if ($registration->notes)
                                    <div class="mt-1 max-w-xs text-xs text-slate-500">{{ $registration->notes }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $registration->activity?->title ?? '—' }}</td>
                            <td class="px-5 py-4 text-slate-600">
                                <div>{{ $registration->email }}</div>
                                @if ($registration->phone)
                                    <div class="text-xs text-slate-400">{{ $registration->phone }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-slate-500">{{ $registration->created_at->format('M j, Y g:i A') }}</td>
                            <td class="px-5 py-4 text-right">
                                <form method="POST" action="{{ route('admin.registrations.destroy', $registration) }}"
                                      onsubmit="return confirm('Remove this registration?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-semibold text-red-600 hover:text-red-500">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-500">No registrations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $registrations->links() }}
    </div>
</x-admin-layout>
