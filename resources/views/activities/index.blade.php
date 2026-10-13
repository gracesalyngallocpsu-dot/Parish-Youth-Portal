<x-public-layout title="Activities">
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-extrabold text-slate-900">Activities</h1>
            <p class="mt-2 max-w-2xl text-slate-500">Browse our upcoming gatherings and revisit past events.</p>

            <div class="mt-6 inline-flex rounded-xl bg-slate-100 p-1">
                <a href="{{ route('activities.index', ['filter' => 'upcoming']) }}"
                   class="rounded-lg px-4 py-2 text-sm font-semibold {{ $filter === 'upcoming' ? 'bg-white text-parish-800 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                    Upcoming
                </a>
                <a href="{{ route('activities.index', ['filter' => 'past']) }}"
                   class="rounded-lg px-4 py-2 text-sm font-semibold {{ $filter === 'past' ? 'bg-white text-parish-800 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                    Past
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if ($activities->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-500">
                No {{ $filter }} activities found.
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($activities as $activity)
                    @include('activities.partials.card', ['activity' => $activity])
                @endforeach
            </div>

            <div class="mt-10">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</x-public-layout>
