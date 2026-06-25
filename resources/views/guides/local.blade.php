@extends('layouts.public')

@section('title', "Elevage Abyssin dans le Morbihan - Saint-Ave, Vannes et alentours")
@section('meta_description', "Presentation locale de la chatterie : elevage d'Abyssins a Saint-Ave, proche de Vannes, dans le Morbihan, avec contact direct et informations claires.")
@section('canonical', route('guides.local'))

@section('content')
    @php
        $site = config('chatterie.site');
        $serviceAreas = config('chatterie.seo.service_area', []);
        $breadcrumbSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Guide local Morbihan', 'item' => route('guides.local')],
            ],
        ];
        $articleSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => "Elevage Abyssin dans le Morbihan",
            'description' => "Guide local sur la chatterie et les demandes d'adoption a Saint-Ave, Vannes et dans le Morbihan.",
            'author' => ['@type' => 'Person', 'name' => data_get($site, 'owner_name', data_get($site, 'name'))],
            'publisher' => ['@type' => 'Organization', 'name' => data_get($site, 'name')],
            'mainEntityOfPage' => route('guides.local'),
        ];
    @endphp

    <section class="hero-glow glass-panel overflow-hidden px-6 py-10 sm:px-8 lg:px-12">
        <div class="max-w-4xl">
            <p class="eyebrow">Guide local</p>
            <h1 class="page-title mt-4">Un elevage d'Abyssins a Saint-Ave, proche de Vannes, dans le Morbihan</h1>
            <p class="body-copy mt-6 max-w-3xl">
                Pour de nombreuses familles, la recherche commence avec des termes comme “elevage Abyssin Morbihan”
                ou “chaton Abyssin Vannes”. Cette page rassemble les informations locales essentielles pour comprendre
                ou se situe la chatterie, comment se passe un premier echange et quelles zones sont habituellement concernees.
            </p>
        </div>
    </section>

    <section class="mt-12 grid gap-6 lg:grid-cols-[1fr_1fr]">
        <article class="section-card p-8">
            <p class="eyebrow">Zone locale</p>
            <h2 class="section-title mt-4">Une chatterie visible dans le Morbihan</h2>
            <p class="body-copy mt-5">
                La chatterie est situee a {{ data_get($site, 'city', 'Saint-Ave') }} et s'adresse naturellement
                aux familles de Vannes, du Morbihan et plus largement de Bretagne qui souhaitent echanger autour
                d'un projet d'adoption d'Abyssin.
            </p>
            @if ($serviceAreas !== [])
                <div class="mt-6 flex flex-wrap gap-3">
                    @foreach ($serviceAreas as $area)
                        <span class="tag-chip">{{ $area }}</span>
                    @endforeach
                </div>
            @endif
        </article>

        <article class="luminous-panel p-8">
            <p class="text-sm uppercase tracking-[0.24em] text-white/65">Contact</p>
            <h2 class="mt-4 font-display text-5xl leading-tight text-white">Le plus utile reste souvent un premier echange simple</h2>
            <p class="mt-5 text-sm leading-7 text-white/85">
                Disponibilites, temperament, distance, organisation du foyer et calendrier d'adoption :
                quelques messages suffisent souvent pour clarifier si un profil correspond a votre recherche.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('contact') }}" class="btn-primary">Contacter la chatterie</a>
                <a href="{{ route('cats.index') }}" class="btn-secondary border-white/15 bg-white text-amber-900">Voir les profils</a>
            </div>
        </article>
    </section>
@endsection

@push('structured_data')
    <script type="application/ld+json">@json($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
    <script type="application/ld+json">@json($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
@endpush
