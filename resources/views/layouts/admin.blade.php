@php
    $adminNavItems = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => request()->routeIs('admin.dashboard')],
        ['label' => 'Chats', 'route' => 'admin.cats.index', 'active' => request()->routeIs('admin.cats.*')],
        ['label' => 'Categories', 'route' => 'admin.categories.index', 'active' => request()->routeIs('admin.categories.*')],
        ['label' => 'Voir le site', 'route' => 'home', 'active' => false],
    ];
@endphp
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin - Chatterie')</title>
        <link rel="icon" type="image/png" href="{{ asset('images/soleils-orient-emblem.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/soleils-orient-emblem.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="admin-shell">
        <div class="min-h-screen lg:flex">
            <aside class="admin-sidebar w-full border-b lg:flex lg:w-80 lg:flex-col lg:border-b-0 lg:border-r">
                <div class="px-4 py-4 sm:px-5 lg:px-6 lg:py-6">
                    <div class="admin-panel px-4 py-4 sm:px-5">
                        <div class="flex items-center justify-between gap-3">
                            <a href="{{ route('admin.dashboard') }}" class="flex min-w-0 items-center gap-3">
                                <span class="brand-mark h-12 w-12 shrink-0 p-1">
                                    <img src="{{ asset('images/soleils-orient-emblem.png') }}" alt="Soleils d'Orient" class="h-full w-full rounded-full object-cover">
                                </span>
                                <span class="min-w-0">
                                    <span class="block truncate font-display text-2xl leading-none text-amber-950">Admin</span>
                                    <span class="mt-1 block text-[10px] font-semibold uppercase tracking-[0.24em] text-amber-800/60">Soleils d'Orient</span>
                                </span>
                            </a>

                            <button
                                type="button"
                                class="mobile-nav-toggle inline-flex h-11 w-11 items-center justify-center rounded-full border border-amber-200 bg-white/80 text-amber-900 transition hover:bg-white lg:hidden"
                                data-mobile-nav-toggle
                                data-mobile-nav-target="admin-site-nav"
                                aria-expanded="false"
                                aria-controls="admin-site-nav"
                                aria-label="Ouvrir le menu admin"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 menu-open-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="hidden h-6 w-6 menu-close-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
                                </svg>
                            </button>
                        </div>

                        <div
                            id="admin-site-nav"
                            class="mt-4 hidden border-t border-amber-100 pt-4 lg:block lg:border-t-0 lg:pt-6"
                            data-mobile-nav
                        >
                            <nav class="grid gap-2">
                                @foreach ($adminNavItems as $item)
                                    <a
                                        href="{{ route($item['route']) }}"
                                        class="admin-nav-link {{ $item['active'] ? 'admin-nav-link-active' : '' }}"
                                    >
                                        {{ $item['label'] }}
                                    </a>
                                @endforeach
                            </nav>

                            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                                @csrf
                                <button type="submit" class="btn-outline w-full justify-center">
                                    Deconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <header class="admin-panel mb-6 px-6 py-6">
                    <div class="flex flex-wrap items-end justify-between gap-4">
                        <div>
                            <p class="eyebrow">Administration</p>
                            <h1 class="mt-3 text-4xl font-semibold text-amber-950 sm:text-5xl">@yield('page-title', 'Dashboard')</h1>
                            <p class="mt-2 text-sm leading-7 text-stone-600">Gestion des chats, categories et contenus de la chatterie.</p>
                        </div>
                    </div>
                </header>

                @include('partials.flash')

                @yield('content')
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
