@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ? $title.' — Admin' : 'Admin' }} — {{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-100 text-slate-800">
        <div x-data="{ sidebar: false }" class="min-h-screen">
            <div x-show="sidebar" x-transition.opacity @click="sidebar = false" class="fixed inset-0 z-30 bg-slate-900/40 lg:hidden"></div>

            <aside :class="sidebar ? 'translate-x-0' : '-translate-x-full'"
                   class="fixed inset-y-0 left-0 z-40 w-64 transform bg-slate-900 transition-transform duration-200 lg:translate-x-0">
                <div class="flex h-16 items-center gap-2 px-6 border-b border-white/10">
                    <img src="/images/parishlogo.jpg" alt="{{ config('app.name') }}" class="h-9 w-9 rounded-lg object-cover">
                    <div class="leading-tight">
                        <p class="font-bold text-white">Parish Youth</p>
                        <p class="text-xs text-slate-400">Admin Panel</p>
                    </div>
                </div>

                <nav class="mt-6 px-3 space-y-1">
                    @php
                        $links = [
                            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'active' => 'admin.dashboard'],
                            ['route' => 'admin.activities.index', 'label' => 'Activities', 'active' => 'admin.activities.*'],
                            ['route' => 'admin.announcements.index', 'label' => 'Announcements', 'active' => 'admin.announcements.*'],
                            ['route' => 'admin.registrations.index', 'label' => 'Registrations', 'active' => 'admin.registrations.*'],
                        ];
                    @endphp

                    @foreach ($links as $link)
                        <a href="{{ route($link['route']) }}"
                           class="block rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs($link['active']) ? 'bg-parish-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="absolute bottom-0 left-0 right-0 p-3 border-t border-white/10">
                    <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white">
                        &larr; View public site
                    </a>
                </div>
            </aside>

            <div class="lg:pl-64">
                <header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6">
                    <div class="flex items-center gap-3">
                        <button @click="sidebar = ! sidebar" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 lg:hidden">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <h1 class="text-lg font-bold text-slate-900">{{ $title ?? 'Dashboard' }}</h1>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="hidden text-sm text-slate-500 sm:block">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-lg bg-slate-900 px-3 py-1.5 text-sm font-semibold text-white hover:bg-slate-700">Log out</button>
                        </form>
                    </div>
                </header>

                @if (session('success'))
                    <div class="px-4 sm:px-6 pt-6">
                        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <main class="p-4 sm:p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
