@extends('layouts.public')

@section('title', "Caractere de l'Abyssin - Guide race et foyer ideal")
@section('meta_description', "Decouvrez le caractere du chat Abyssin, son niveau d'energie, sa relation a l'humain et le type de foyer qui lui convient le mieux.")
@section('canonical', route('guides.breed'))

@section('content')
    @php
        $site = config('chatterie.site');
        $breadcrumbSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => "Guide race Abyssin", 'item' => route('guides.breed')],
            ],
        ];
        $articleSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => "Le caractere du chat Abyssin",
            'description' => "Guide sur le temperament de l'Abyssin et le type de foyer qui lui convient.",
            'author' => ['@type' => 'Person', 'name' => data_get($site, 'owner_name', data_get($site, 'name'))],
            'publisher' => ['@type' => 'Organization', 'name' => data_get($site, 'name')],
            'mainEntityOfPage' => route('guides.breed'),
        ];
    @endphp

    <section class="hero-glow glass-panel overflow-hidden px-6 py-10 sm:px-8 lg:px-12">
        <div class="max-w-4xl">
            <p class="eyebrow">Guide race</p>
            <h1 class="page-title mt-4">Quel est vraiment le caractere du chat Abyssin ?</h1>
            <p class="body-copy mt-6 max-w-3xl">
                L'Abyssin est souvent recherche pour son elegance et sa presence, mais ce qui marque surtout
                au quotidien, c'est son intelligence, son mouvement et son besoin d'interaction. Cette page
                vous aide a savoir si ce temperament correspond bien a votre foyer.
            </p>
        </div>
    </section>

    <section class="mt-12 grid gap-6 md:grid-cols-3">
        <article class="section-card p-6">
            <p class="eyebrow">Energie</p>
            <h2 class="mt-3 text-4xl font-semibold text-amber-950">Active</h2>
            <p class="subtle-text mt-4">
                L'Abyssin aime grimper, observer, jouer et participer a ce qui se passe autour de lui.
            </p>
        </article>
        <article class="section-card p-6">
            <p class="eyebrow">Lien humain</p>
            <h2 class="mt-3 text-4xl font-semibold text-amber-950">Proche</h2>
            <p class="subtle-text mt-4">
                Il cherche souvent la presence du foyer et supporte mieux les environnements attentifs et vivants.
            </p>
        </article>
        <article class="section-card p-6">
            <p class="eyebrow">Rythme ideal</p>
            <h2 class="mt-3 text-4xl font-semibold text-amber-950">Stimule</h2>
            <p class="subtle-text mt-4">
                Jeux, hauteur, interactions et routine rassurante l'aident a s'epanouir durablement.
            </p>
        </article>
    </section>

    <section class="mt-12 grid gap-6 lg:grid-cols-[1fr_1fr]">
        <article class="section-card p-8">
            <p class="eyebrow">Pour quel foyer ?</p>
            <h2 class="section-title mt-4">Les familles qui apprecient vraiment l'Abyssin</h2>
            <p class="body-copy mt-5">
                Cette race convient souvent aux personnes qui veulent un chat present, vif et engage dans la
                vie du foyer. Elle correspond bien a ceux qui aiment observer, jouer, echanger et amenager
                un cadre un peu plus riche qu'un simple espace de repos.
            </p>
            <p class="subtle-text mt-5">
                En revanche, si vous cherchez un chat tres independant ou peu demonstratif, l'Abyssin peut
                ne pas etre le profil le plus simple a long terme.
            </p>
        </article>

        <article class="luminous-panel p-8">
            <p class="text-sm uppercase tracking-[0.24em] text-white/65">Conseil pratique</p>
            <h2 class="mt-4 font-display text-5xl leading-tight text-white">La bonne question n'est pas “est-il beau ?” mais “vivra-t-il bien chez nous ?”</h2>
            <p class="mt-5 text-sm leading-7 text-white/85">
                Un beau profil attire vite le regard. Le bon foyer, lui, se construit avec du temps, de l'attention
                et une vraie coherence entre les besoins du chat et votre quotidien.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('guides.adoption') }}" class="btn-secondary border-white/15 bg-white text-amber-900">Guide adoption</a>
                <a href="{{ route('contact') }}" class="btn-primary">Nous contacter</a>
            </div>
        </article>
    </section>
@endsection

@push('structured_data')
    <script type="application/ld+json">@json($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
    <script type="application/ld+json">@json($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
@endpush
