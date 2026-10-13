<x-public-layout>
    <section class="hero-gradient relative overflow-hidden">
        <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-white/15 blur-3xl"></div>
        <div class="absolute -bottom-32 -left-16 h-96 w-96 rounded-full bg-amber-300/25 blur-3xl"></div>
        <div class="absolute right-1/3 -top-40 h-80 w-80 rounded-full bg-orange-400/20 blur-3xl mix-blend-screen"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-transparent to-black/10"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
            <span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white ring-1 ring-white/25">
                Parish Youth Ministry
            </span>
            <h1 class="mt-5 max-w-3xl text-4xl font-extrabold leading-tight text-white drop-shadow-sm sm:text-5xl">
                Growing together in faith, friendship, and service.
            </h1>
            <p class="mt-5 max-w-2xl text-lg text-amber-50">
                Discover upcoming activities, sign up for events, and stay up to date with the latest news from our parish youth community.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('activities.index') }}" class="rounded-xl bg-white px-6 py-3 text-sm font-bold text-[#7A3F1F] shadow-lg shadow-[#5C341F]/30 hover:bg-amber-50">
                    Browse activities
                </a>
                <a href="{{ route('announcements.index') }}" class="rounded-xl bg-white/15 px-6 py-3 text-sm font-bold text-white ring-1 ring-white/30 backdrop-blur hover:bg-white/25">
                    Read announcements
                </a>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-end justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900 sm:text-3xl">Upcoming activities</h2>
                <p class="mt-1 text-slate-500">Join us at our next gatherings and events.</p>
            </div>
            <a href="{{ route('activities.index') }}" class="hidden sm:inline-flex text-sm font-semibold text-parish-700 hover:text-parish-600">View all &rarr;</a>
        </div>

        @if ($activities->isEmpty())
            <div class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500">
                No upcoming activities just yet. Please check back soon!
            </div>
        @else
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($activities as $activity)
                    @include('activities.partials.card', ['activity' => $activity])
                @endforeach
            </div>
        @endif
    </section>

    <section class="bg-white border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900 sm:text-3xl">Latest announcements</h2>
                    <p class="mt-1 text-slate-500">News and updates from the youth ministry.</p>
                </div>
                <a href="{{ route('announcements.index') }}" class="hidden sm:inline-flex text-sm font-semibold text-parish-700 hover:text-parish-600">View all &rarr;</a>
            </div>

            @if ($announcements->isEmpty())
                <div class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center text-slate-500">
                    No announcements yet.
                </div>
            @else
                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    @foreach ($announcements as $announcement)
                        <a href="{{ route('announcements.show', $announcement) }}"
                           class="flex flex-col rounded-2xl bg-parish-50 p-6 ring-1 ring-parish-100 transition hover:bg-white hover:shadow-md hover:ring-parish-200">
                            <time class="text-xs font-semibold uppercase tracking-wide text-parish-700">
                                {{ ($announcement->published_at ?? $announcement->created_at)->format('M j, Y') }}
                            </time>
                            <h3 class="mt-2 text-lg font-bold text-slate-900">{{ $announcement->title }}</h3>
                            <p class="mt-2 flex-1 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($announcement->body, 120) }}</p>
                            <span class="mt-4 text-sm font-semibold text-parish-700">Read more &rarr;</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-public-layout>
