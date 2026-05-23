<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Connexion Admin - Chatterie des Soleils d'Orient</title>
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
        <main class="container-page flex min-h-screen items-center justify-center py-10">
            <section class="auth-card w-full max-w-md p-6 sm:p-8">
                <div class="flex items-center gap-4">
                    <span class="brand-mark h-16 w-16 shrink-0 p-1.5">
                        <img src="{{ asset('images/soleils-orient-emblem.png') }}" alt="Soleils d'Orient" class="h-full w-full rounded-full object-cover">
                    </span>
                    <div>
                        <p class="eyebrow">Acces securise</p>
                        <h1 class="mt-2 font-display text-4xl text-amber-950">Connexion admin</h1>
                    </div>
                </div>

                <p class="subtle-text mt-4">
                    L'espace administration est protege. Connectez-vous pour gerer les chats, categories et contenus.
                </p>

                @if ($errors->any())
                    <div class="mt-6 rounded-[1.4rem] border border-red-200 bg-red-50/80 px-4 py-3 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="mt-7 space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="label-base">Adresse e-mail</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="input-base"
                        >
                    </div>

                    <div>
                        <label for="password" class="label-base">Mot de passe</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            class="input-base"
                        >
                    </div>

                    <label class="flex items-center gap-3 text-sm text-stone-600">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-amber-300 text-amber-700 focus:ring-amber-300">
                        <span>Rester connecte</span>
                    </label>

                    <button type="submit" class="btn-primary w-full">Se connecter</button>
                </form>
            </section>
        </main>
    </body>
</html>
