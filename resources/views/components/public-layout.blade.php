@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ? $title.' — '.config('app.name') : config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800">
        <div class="min-h-screen flex flex-col">
            <nav x-data="{ open: false }" class="bg-white/90 backdrop-blur border-b border-slate-200 sticky top-0 z-40">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center gap-10">
                            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                                <img src="/images/parishlogo.jpg" alt="{{ config('app.name') }}" class="h-8 w-auto">
                                <span class="font-extrabold tracking-tight text-slate-900">Parish Youth</span>
                            </a>

                            <div class="hidden sm:flex items-center gap-1">
                                <a href="{{ route('home') }}"
                                   class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('home') ? 'text-parish-800 bg-parish-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Home
                                </a>
                                <a href="{{ route('activities.index') }}"
                                   class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('activities.*') ? 'text-parish-800 bg-parish-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Activities
                                </a>
                                <a href="{{ route('announcements.index') }}"
                                   class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('announcements.*') ? 'text-parish-800 bg-parish-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Announcements
                                </a>
                            </div>
                        </div>

                        <div class="hidden sm:flex items-center gap-3">
                            @auth
                                @if (auth()->user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-parish-700">Admin Panel</a>
                                @endif
                                <span class="text-sm text-slate-400">{{ auth()->user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Log out</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-parish-700">Log in</a>
                                <a href="{{ route('register') }}" class="rounded-lg bg-parish-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-parish-800">Join us</a>
                            @endauth
                        </div>

                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 hover:bg-slate-100">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-200 bg-white">
                    <div class="px-4 pt-2 pb-4 space-y-1">
                        <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 font-medium text-slate-700 hover:bg-slate-100">Home</a>
                        <a href="{{ route('activities.index') }}" class="block rounded-lg px-3 py-2 font-medium text-slate-700 hover:bg-slate-100">Activities</a>
                        <a href="{{ route('announcements.index') }}" class="block rounded-lg px-3 py-2 font-medium text-slate-700 hover:bg-slate-100">Announcements</a>
                        <div class="pt-2 border-t border-slate-200">
                            @auth
                                @if (auth()->user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 font-medium text-parish-700 hover:bg-parish-50">Admin Panel</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left rounded-lg px-3 py-2 font-medium text-slate-700 hover:bg-slate-100">Log out</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="block rounded-lg px-3 py-2 font-medium text-slate-700 hover:bg-slate-100">Log in</a>
                                <a href="{{ route('register') }}" class="block rounded-lg px-3 py-2 font-medium text-parish-700 hover:bg-parish-50">Join us</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            @if (session('success'))
                <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6">
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="border-t border-slate-200 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <img src="/images/parishlogo.jpg" alt="{{ config('app.name') }}" class="h-8 w-8 rounded-lg object-cover">
                        <span class="font-semibold text-slate-900">Parish Youth Portal</span>
                    </div>
                    <p class="text-sm text-slate-500">&copy; {{ now()->year }} Parish Youth Ministry. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
