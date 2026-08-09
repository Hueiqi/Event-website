<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MyGovEvent') · MyGovEvent</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col bg-slate-50">
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur">
        <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-700 text-white shadow-sm">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </span>
                <span class="text-lg font-bold tracking-tight text-slate-900">
                    MyGov<span class="text-primary-700">Event</span>
                </span>
            </a>

            {{-- Desktop nav --}}
            <div class="hidden items-center gap-1 md:flex">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home', 'events.show', 'events.search') ? 'active' : '' }} rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Browse Events</a>

                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Dashboard</a>

                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.reports') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Reports</a>
                    @endif
                @endauth
            </div>

            {{-- Desktop actions --}}
            <div class="hidden items-center gap-3 md:flex">
                @auth
                    <div class="relative" data-dropdown>
                        <button type="button" data-dropdown-button class="flex items-center gap-2 rounded-full py-1 pl-1 pr-3 text-sm font-medium text-slate-700 ring-1 ring-inset ring-slate-200 transition hover:bg-slate-50">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 text-sm font-bold text-primary-800">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div data-dropdown-menu class="absolute right-0 mt-2 hidden w-52 overflow-hidden rounded-xl border border-slate-200 bg-white py-1 shadow-lg">
                            <div class="border-b border-slate-100 px-4 py-2.5">
                                <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                                <p class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">My Profile</a>
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.activity') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Activity Log</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-rose-600 hover:bg-rose-50">Sign out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:text-slate-900">Sign in</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Create account</a>
                @endauth
            </div>

            {{-- Mobile menu button --}}
            <button type="button" data-mobile-toggle class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 md:hidden" aria-label="Toggle navigation">
                <svg data-icon-open class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg data-icon-close class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </nav>

        {{-- Mobile menu --}}
        <div data-mobile-menu class="hidden border-t border-slate-200 bg-white px-4 py-3 md:hidden">
            <div class="flex flex-col gap-1">
                <a href="{{ route('home') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">Browse Events</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">My Profile</a>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.reports') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">Reports</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-lg px-3 py-2.5 text-left text-sm font-medium text-rose-600 hover:bg-rose-50">Sign out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">Sign in</a>
                    <a href="{{ route('register') }}" class="btn btn-primary mt-1">Create account</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Flash messages --}}
    <div class="mx-auto w-full max-w-7xl px-4 pt-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <x-ui.alert type="success" title="Success">{{ session('success') }}</x-ui.alert>
        @endif
        @if (session('error'))
            <x-ui.alert type="danger" title="Error">{{ session('error') }}</x-ui.alert>
        @endif
        @if (session('info'))
            <x-ui.alert type="info">{{ session('info') }}</x-ui.alert>
        @endif
        @if ($errors->any() && !request()->is('login', 'register'))
            <x-ui.alert type="danger" title="Please fix the following errors">
                <ul class="mt-1 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-ui.alert>
        @endif
    </div>

    <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 py-6 text-sm text-slate-500 sm:flex-row sm:px-6 lg:px-8">
            <p>© {{ date('Y') }} MyGovEvent · Government Event Management System</p>
            <p class="flex items-center gap-1.5">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                All systems operational
            </p>
        </div>
    </footer>

    <script>
        (function () {
            const toggle = document.querySelector('[data-mobile-toggle]');
            const menu = document.querySelector('[data-mobile-menu]');
            if (toggle && menu) {
                toggle.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                    document.querySelector('[data-icon-open]').classList.toggle('hidden');
                    document.querySelector('[data-icon-close]').classList.toggle('hidden');
                });
            }

            const dropdown = document.querySelector('[data-dropdown]');
            if (dropdown) {
                const button = dropdown.querySelector('[data-dropdown-button]');
                const menu = dropdown.querySelector('[data-dropdown-menu]');
                button.addEventListener('click', (e) => {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                });
                document.addEventListener('click', () => menu.classList.add('hidden'));
            }
        })();
    </script>
    @yield('scripts')
</body>
</html>
