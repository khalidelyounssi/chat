@extends('layouts.public')

@section('title', "Adopter un chaton Abyssin a Saint-Ave - Guide pratique")
@section('meta_description', "Guide pratique pour adopter un chaton Abyssin a Saint-Ave : questions a poser, rythme du foyer, disponibilites et conseils avant l'adoption.")
@section('canonical', route('guides.adoption'))

@section('content')
    @php
        $site = config('chatterie.site');
        $city = (string) data_get($site, 'city', 'Saint-Ave');
        $breadcrumbSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Guide adoption', 'item' => route('guides.adoption')],
            ],
        ];
        $articleSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => "Adopter un chaton Abyssin a {$city}",
            'description' => "Guide pratique pour preparer l'adoption d'un chaton Abyssin a {$city}.",
            'author' => ['@type' => 'Person', 'name' => data_get($site, 'owner_name', data_get($site, 'name'))],
            'publisher' => ['@type' => 'Organization', 'name' => data_get($site, 'name')],
            'mainEntityOfPage' => route('guides.adoption'),
        ];
    @endphp

    <section class="hero-glow glass-panel overflow-hidden px-6 py-10 sm:px-8 lg:px-12">
        <div class="max-w-4xl">
            <p class="eyebrow">Guide adoption</p>
            <h1 class="page-title mt-4">Adopter un chaton Abyssin a {{ $city }} : ce qu'il faut vraiment preparer</h1>
            <p class="body-copy mt-6 max-w-3xl">
                Avant d'adopter un chaton Abyssin, le plus important n'est pas seulement la disponibilite
                du profil, mais la compatibilite entre son temperament, votre rythme de vie et l'equilibre
                du foyer. Ce guide resume les points concrets a verifier avant un premier echange.
            </p>
        </div>
    </section>

    <section class="mt-12 grid gap-6 lg:grid-cols-[1fr_1fr]">
        <article class="section-card p-8">
            <p class="eyebrow">Avant la prise de contact</p>
            <h2 class="section-title mt-4">Les 4 questions qui font gagner du temps</h2>
            <div class="mt-6 grid gap-4">
                <div class="detail-pill">
                    <p class="text-base font-semibold text-amber-950">Combien de temps le chat sera-t-il seul dans la journee ?</p>
                </div>
                <div class="detail-pill">
                    <p class="text-base font-semibold text-amber-950">Votre foyer comprend-il des enfants ou d'autres animaux ?</p>
                </div>
                <div class="detail-pill">
                    <p class="text-base font-semibold text-amber-950">Cherchez-vous un chaton immediatement disponible ou un projet a moyen terme ?</p>
                </div>
                <div class="detail-pill">
                    <p class="text-base font-semibold text-amber-950">Pouvez-vous offrir interactions, jeux et environnement stimulant ?</p>
                </div>
            </div>
        </article>

        <article class="luminous-panel p-8">
            <p class="text-sm uppercase tracking-[0.24em] text-white/65">Abyssin</p>
            <h2 class="mt-4 font-display text-5xl leading-tight text-white">Une race vive, curieuse et tres relationnelle</h2>
            <p class="mt-5 text-sm leading-7 text-white/85">
                L'Abyssin convient bien aux foyers qui aiment la presence d'un chat actif, proche de l'humain
                et implique dans la vie quotidienne. Il a besoin d'attention, de jeu et d'un cadre coherent.
            </p>
            <div class="mt-6 flex flex-wrap gap-3">
                <span class="tag-chip border-white/20 bg-white/10 text-white">Interactif</span>
                <span class="tag-chip border-white/20 bg-white/10 text-white">Elegant</span>
                <span class="tag-chip border-white/20 bg-white/10 text-white">Sensible</span>
            </div>
        </article>
    </section>

    <section class="mt-12">
        <div class="section-card p-8">
            <p class="eyebrow">Pourquoi un echange humain reste essentiel</p>
            <h2 class="section-title mt-4">Un bon profil ne se choisit pas uniquement sur photo</h2>
            <p class="body-copy mt-5">
                Un site peut vous aider a comparer les profils, lire les statuts, regarder les images et
                comprendre les premieres informations utiles. Mais le bon choix depend aussi de votre foyer,
                de vos habitudes et de ce que vous attendez vraiment d'un compagnon au quotidien.
            </p>
            <p class="subtle-text mt-5">
                C'est pour cela qu'un premier contact reste la meilleure etape pour confirmer si un chaton
                Abyssin disponible a {{ $city }} correspond reellement a votre projet.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('cats.index') }}" class="btn-primary">Voir les chats visibles</a>
                <a href="{{ route('contact') }}" class="btn-secondary">Poser une question avant d'adopter</a>
            </div>
        </div>
    </section>
@endsection

@push('structured_data')
    <script type="application/ld+json">@json($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
    <script type="application/ld+json">@json($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
@endpush
