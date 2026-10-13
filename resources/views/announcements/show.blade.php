<x-public-layout :title="$announcement->title">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <a href="{{ route('announcements.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-slate-500 hover:text-parish-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to announcements
        </a>

        <article class="mt-6 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-10">
            <time class="text-xs font-semibold uppercase tracking-wide text-parish-700">
                {{ ($announcement->published_at ?? $announcement->created_at)->format('F j, Y') }}
            </time>
            <h1 class="mt-3 text-3xl font-extrabold leading-tight text-slate-900 sm:text-4xl">{{ $announcement->title }}</h1>

            <div class="mt-6 whitespace-pre-line text-lg leading-relaxed text-slate-700">
                {{ $announcement->body }}
            </div>
        </article>
    </div>
</x-public-layout>
