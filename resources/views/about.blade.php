@extends('layouts.public')

@section('title', 'A propos de la chatterie d\'Abyssins - Chatterie des Soleils d\'Orient')
@section('meta_description', 'Presentation de la chatterie, de son approche familiale, de la socialisation des Abyssins et de l\'accompagnement a l\'adoption.')
@section('canonical', route('about'))

@section('content')
    @php
        $site = config('chatterie.site');
        $commitments = config('chatterie.commitments', []);
        $adoptionSteps = config('chatterie.adoption_steps', []);
        $breadcrumbSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Accueil',
                    'item' => route('home'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'A propos',
                    'item' => route('about'),
                ],
            ],
        ];
    @endphp

    <section class="hero-glow glass-panel overflow-hidden px-6 py-10 sm:px-8 lg:px-12">
        <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
            <div class="mx-auto w-full max-w-md">
                <img src="{{ asset('images/soleils-orient-emblem.png') }}" alt="Identite visuelle de la chatterie" class="w-full">
            </div>
            <div>
                <p class="eyebrow">A propos</p>
                <h1 class="page-title mt-4">Une chatterie familiale pensee pour durer</h1>
                <p class="body-copy mt-6 max-w-2xl">
                    Nous elevons des Abyssins dans une logique de qualite, de confiance et de dialogue.
                    Le site a pour role de presenter l'essentiel sans surpromesse : temperament, disponibilites,
                    modalites de contact et niveau d'accompagnement.
                </p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <span class="tag-chip">{{ data_get($site, 'legal_status') }}</span>
                    <span class="tag-chip">{{ data_get($site, 'city') }}, {{ data_get($site, 'country') }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-12 grid gap-6 md:grid-cols-3">
        <article class="section-card p-6">
            <p class="eyebrow">Caractere</p>
            <h2 class="mt-3 text-4xl font-semibold text-amber-950">Curieux et proche</h2>
            <p class="subtle-text mt-4">
                L'Abyssin aime l'interaction, observe tout et cherche une vraie place dans la vie du foyer.
            </p>
        </article>
        <article class="section-card p-6">
            <p class="eyebrow">Sante</p>
            <h2 class="mt-3 text-4xl font-semibold text-amber-950">Suivi rigoureux</h2>
            <p class="subtle-text mt-4">
                Nous privilegions la prevention, le suivi et une communication simple autour de chaque profil.
            </p>
        </article>
        <article class="section-card p-6">
            <p class="eyebrow">Socialisation</p>
            <h2 class="mt-3 text-4xl font-semibold text-amber-950">Equilibre familial</h2>
            <p class="subtle-text mt-4">
                Les chatons grandissent dans un environnement humain, doux et rassurant, avec des reperes stables.
            </p>
        </article>
    </section>

    <section class="mt-12 grid gap-6 lg:grid-cols-[1fr_1fr]">
        <article class="section-card p-8">
            <p class="eyebrow">Ce que vous pouvez attendre</p>
            <h2 class="section-title mt-4">Une presentation honnete et un contact accessible</h2>
            <div class="mt-6 grid gap-4">
                @foreach ($commitments as $commitment)
                    <div class="detail-pill">
                        <p class="text-base font-semibold text-amber-950">{{ $commitment }}</p>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="luminous-panel p-8">
            <p class="text-sm uppercase tracking-[0.24em] text-white/65">Adoption</p>
            <h2 class="mt-4 font-display text-5xl leading-tight text-white">Comment se passe l'echange ?</h2>
            <div class="mt-6 grid gap-4">
                @foreach ($adoptionSteps as $index => $step)
                    <div class="rounded-[1.5rem] bg-white/10 px-5 py-4 backdrop-blur-sm">
                        <p class="text-xs uppercase tracking-[0.24em] text-white/60">Etape {{ $index + 1 }}</p>
                        <p class="mt-2 text-sm leading-7 text-white/85">{{ $step }}</p>
                    </div>
                @endforeach
            </div>
        </article>
    </section>

    <section class="mt-12">
        <div class="section-card px-6 py-10 sm:px-10">
            <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <p class="eyebrow">Besoin d'un premier echange ?</p>
                    <h2 class="section-title mt-3">Nous repondons volontiers a vos questions</h2>
                    <p class="subtle-text mt-4 max-w-2xl">
                        Temperament, compatibilite avec votre foyer, disponibilites et modalites :
                        nous preferons un contact clair des le debut.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3 lg:justify-end">
                    <a href="{{ route('contact') }}" class="btn-primary">Page contact</a>
                    <a href="{{ route('cats.index') }}" class="btn-secondary">Voir les chats</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('structured_data')
    <script type="application/ld+json">@json($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
@endpush
