@props(['activity'])

<article class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 transition hover:shadow-md hover:ring-parish-200">
    <a href="{{ route('activities.show', $activity) }}" class="block">
        @if ($activity->image_url)
            <img src="{{ $activity->image_url }}" alt="{{ $activity->title }}" class="h-44 w-full object-cover transition duration-300 group-hover:scale-105">
        @else
            <div class="flex h-44 w-full items-center justify-center bg-gradient-to-br from-parish-500 to-parish-800">
                <span class="text-3xl font-extrabold text-white/90">
                    {{ $activity->starts_at->format('M') }}&nbsp;{{ $activity->starts_at->format('d') }}
                </span>
            </div>
        @endif
    </a>

    <div class="flex flex-1 flex-col p-5">
        <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-parish-700">
            <span>{{ $activity->starts_at->format('M j, Y') }}</span>
            <span class="text-slate-300">&bull;</span>
            <span>{{ $activity->starts_at->format('g:i A') }}</span>
        </div>

        <h3 class="mt-2 text-lg font-bold text-slate-900">
            <a href="{{ route('activities.show', $activity) }}" class="hover:text-parish-600">{{ $activity->title }}</a>
        </h3>

        @if ($activity->location)
            <p class="mt-1 flex items-center gap-1 text-sm text-slate-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $activity->location }}
            </p>
        @endif

        <p class="mt-3 line-clamp-3 flex-1 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($activity->description, 140) }}</p>

        <a href="{{ route('activities.show', $activity) }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-parish-700 hover:text-parish-600">
            View details
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
</article>
