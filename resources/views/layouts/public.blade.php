@php
    $whatsAppNumber = preg_replace('/\D+/', '', (string) config('chatterie.whatsapp.number'));
    $message = $whatsappMessage ?? config('chatterie.whatsapp.default_text');
    $whatsAppLink = $whatsAppNumber
        ? 'https://wa.me/' . $whatsAppNumber . '?text=' . rawurlencode((string) $message)
        : '#';
    $navItems = [
        ['label' => 'Accueil', 'route' => 'home', 'active' => request()->routeIs('home')],
        ['label' => 'Nos chats', 'route' => 'cats.index', 'active' => request()->routeIs('cats.*')],
        ['label' => 'A propos', 'route' => 'about', 'active' => request()->routeIs('about')],
    ];
@endphp
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', "Chatterie des Soleils d'Orient")</title>
        <link rel="icon" type="image/png" href="{{ asset('images/soleils-orient-emblem.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/soleils-orient-emblem.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="site-shell">
        <header class="sticky top-0 z-50 border-b border-amber-100/70 bg-white/70 backdrop-blur-xl">
            <div class="container-page py-4">
                <div class="navbar-shell px-4 py-4 sm:px-5 lg:px-6">
                    <div class="flex items-center justify-between gap-4 lg:flex-1">
                        <a href="{{ route('home') }}" class="navbar-brand">
                            <span class="brand-mark h-14 w-14 shrink-0 p-1.5 sm:h-16 sm:w-16">
                                <img src="{{ asset('images/soleils-orient-emblem.png') }}" alt="Soleils d'Orient" class="h-full w-full rounded-full object-cover">
                            </span>
                            <span class="min-w-0">
                                <span class="block truncate font-display text-2xl leading-none text-amber-900 sm:text-3xl">Soleils d'Orient</span>
                                <span class="mt-1 block text-[10px] font-semibold uppercase tracking-[0.24em] text-amber-800/60 sm:text-xs">Chatterie d'Abyssins</span>
                            </span>
                        </a>

                        <button
                            type="button"
                            class="mobile-nav-toggle inline-flex h-12 w-12 items-center justify-center rounded-full border border-amber-200 bg-white/80 text-amber-900 transition hover:bg-white lg:hidden"
                            data-mobile-nav-toggle
                            aria-expanded="false"
                            aria-controls="public-site-nav"
                            aria-label="Ouvrir le menu"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 menu-open-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="hidden h-6 w-6 menu-close-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
                            </svg>
                        </button>
                    </div>

                    <div id="public-site-nav" class="navbar-menu" data-mobile-nav>
                        <nav class="navbar-links">
                            @foreach ($navItems as $item)
                                <a
                                    href="{{ route($item['route']) }}"
                                    class="nav-pill {{ $item['active'] ? 'nav-pill-active' : '' }}"
                                >
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                            <a href="{{ route('admin.dashboard') }}" class="nav-pill">Administration</a>
                        </nav>

                        <a href="{{ $whatsAppLink }}" target="_blank" rel="noopener noreferrer" class="navbar-cta">
                            Contactez-nous
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="container-page py-8 sm:py-10 lg:py-12">
            @include('partials.flash')
            @yield('content')
        </main>

        <footer class="mt-10 border-t border-amber-100/70 pb-10 pt-8">
            <div class="container-page">
                <div class="section-card px-6 py-8 sm:px-8">
                    <div class="grid gap-8 lg:grid-cols-[1.3fr_0.7fr] lg:items-end">
                        <div>
                            <p class="eyebrow">Lumiere, elegance, confiance</p>
                            <h2 class="mt-3 text-4xl font-semibold text-amber-950">Chatterie des Soleils d'Orient</h2>
                            <p class="mt-3 max-w-2xl text-sm leading-7 text-stone-600">
                                Elevage d'Abyssins au temperament equilibre, suivi avec soin et presente dans un univers
                                doux, solaire et raffine.
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-4 lg:justify-end">
                            <a href="{{ route('cats.index') }}" class="footer-link">Nos chats</a>
                            <a href="{{ route('about') }}" class="footer-link">A propos</a>
                            <a href="{{ $whatsAppLink }}" target="_blank" rel="noopener noreferrer" class="footer-link">WhatsApp</a>
                        </div>
                    </div>
                    <div class="mt-8 flex flex-col gap-2 border-t border-amber-100 pt-5 text-xs uppercase tracking-[0.2em] text-stone-500 sm:flex-row sm:items-center sm:justify-between">
                        <span>Elevage de chats orientaux</span>
                        <span>Maison Soleils d'Orient</span>
                    </div>
                </div>
            </div>
        </footer>

        @if ($whatsAppNumber)
            <a
                href="{{ $whatsAppLink }}"
                target="_blank"
                rel="noopener noreferrer"
                class="fixed bottom-5 right-5 z-40 inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-600"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                    <path d="M12 2a10 10 0 0 0-8.66 15l-1.1 4a1 1 0 0 0 1.22 1.22l4-1.1A10 10 0 1 0 12 2Zm0 18a7.92 7.92 0 0 1-4.05-1.11 1 1 0 0 0-.76-.1l-2.32.64.64-2.32a1 1 0 0 0-.1-.76A8 8 0 1 1 12 20Zm4.17-5.3-.67-.34c-.22-.11-1.31-.65-1.51-.72s-.34-.11-.49.11-.56.72-.68.87-.25.17-.47.06a6.57 6.57 0 0 1-1.94-1.2 7.28 7.28 0 0 1-1.35-1.67c-.14-.25 0-.39.1-.5.1-.1.22-.25.34-.37s.15-.22.22-.37a.42.42 0 0 0 0-.4c-.05-.11-.49-1.18-.67-1.61s-.36-.37-.49-.37h-.42a.82.82 0 0 0-.59.27 2.47 2.47 0 0 0-.77 1.83 4.31 4.31 0 0 0 .91 2.27 9.73 9.73 0 0 0 3.74 3.3 12.56 12.56 0 0 0 1.25.46 3 3 0 0 0 1.38.09 2.28 2.28 0 0 0 1.51-1.06 1.86 1.86 0 0 0 .13-1.06c-.04-.06-.18-.1-.4-.21Z" />
                </svg>
                WhatsApp
            </a>
        @endif

        @stack('scripts')
    </body>
</html>
