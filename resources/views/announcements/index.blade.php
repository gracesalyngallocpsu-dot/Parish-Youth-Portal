<x-public-layout title="Announcements">
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-extrabold text-slate-900">Announcements</h1>
            <p class="mt-2 max-w-2xl text-slate-500">News and updates from the parish youth ministry.</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if ($announcements->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-500">
                No announcements yet. Please check back soon!
            </div>
        @else
            <div class="space-y-5">
                @foreach ($announcements as $announcement)
                    <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 transition hover:shadow-md">
                        <time class="text-xs font-semibold uppercase tracking-wide text-parish-700">
                            {{ ($announcement->published_at ?? $announcement->created_at)->format('F j, Y') }}
                        </time>
                        <h2 class="mt-2 text-xl font-bold text-slate-900">
                            <a href="{{ route('announcements.show', $announcement) }}" class="hover:text-parish-600">{{ $announcement->title }}</a>
                        </h2>
                        <p class="mt-2 text-slate-600">{{ \Illuminate\Support\Str::limit($announcement->body, 220) }}</p>
                        <a href="{{ route('announcements.show', $announcement) }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-parish-700 hover:text-parish-600">
                            Read more
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </article>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</x-public-layout>
