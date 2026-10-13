<x-public-layout :title="$activity->title">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <a href="{{ route('activities.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-slate-500 hover:text-parish-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to activities
        </a>

        <div class="mt-6 overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
            @if ($activity->image_url)
                <img src="{{ $activity->image_url }}" alt="{{ $activity->title }}" class="h-72 w-full object-cover">
            @else
                <div class="h-56 w-full bg-gradient-to-br from-parish-500 to-parish-800"></div>
            @endif

            <div class="p-6 sm:p-10">
                <div class="flex flex-wrap items-center gap-2">
                    @if ($activity->isPast())
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Past event</span>
                    @else
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Upcoming</span>
                    @endif
                    <span class="rounded-full bg-parish-50 px-3 py-1 text-xs font-semibold text-parish-700">
                        {{ $activity->registrations_count }} registered
                    </span>
                </div>

                <h1 class="mt-4 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $activity->title }}</h1>

                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                        <svg class="h-5 w-5 text-parish-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">When</p>
                            <p class="font-semibold text-slate-800">
                                {{ $activity->starts_at->format('l, M j, Y g:i A') }}
                                @if ($activity->ends_at)
                                    <span class="text-slate-400">–</span> {{ $activity->ends_at->format('g:i A') }}
                                @endif
                            </p>
                        </div>
                    </div>

                    @if ($activity->location)
                        <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                            <svg class="h-5 w-5 text-parish-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Where</p>
                                <p class="font-semibold text-slate-800">{{ $activity->location }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-8 prose prose-slate max-w-none text-slate-700">
                    {!! nl2br(e($activity->description)) !!}
                </div>
            </div>
        </div>

        <div class="mt-8 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-10">
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <h2 class="text-xl font-bold text-slate-900">Register for this activity</h2>
            <p class="mt-1 text-sm text-slate-500">Fill in your details and we'll save your spot.</p>

            <form method="POST" action="{{ route('activities.register', $activity) }}" class="mt-6 grid gap-5 sm:grid-cols-2">
                @csrf

                <div>
                    <x-input-label for="name" value="Full name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" value="Email address" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="phone" value="Phone (optional)" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div class="sm:col-span-2">
                    <x-input-label for="notes" value="Notes (optional)" />
                    <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-parish-500 focus:ring-parish-500">{{ old('notes') }}</textarea>
                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                </div>

                <div class="sm:col-span-2">
                    <button type="submit" class="inline-flex items-center rounded-lg bg-parish-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-parish-800 focus:outline-none focus:ring-2 focus:ring-parish-500 focus:ring-offset-2">
                        Submit registration
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>
