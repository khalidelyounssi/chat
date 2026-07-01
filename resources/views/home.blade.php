@extends('layouts.public')

@section('title', "Chatterie des Soleils d'Orient - Elevage d'Abyssins proche de Vannes")
@section('meta_description', config('chatterie.site.meta_description'))
@section('canonical', route('home'))

@section('content')
    @php
        use Illuminate\Support\Str;

        $site = config('chatterie.site');
        $logoPath = 'images/soleils-orient-emblem.png';
        $logoVersion = file_exists(public_path($logoPath)) ? filemtime(public_path($logoPath)) : null;
        $logoAsset = asset($logoPath) . ($logoVersion ? '?v=' . $logoVersion : '');
        $marketCity = (string) data_get($site, 'market_city', 'Vannes');
        $commitments = config('chatterie.commitments', []);
        $faqItems = config('chatterie.seo.faq', []);
        $serviceAreas = config('chatterie.seo.service_area', []);

        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($faqItems)->map(fn (array $item): array => [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['answer'],
                ],
            ])->all(),
        ];
    @endphp

    <section class="hero-glow glass-panel overflow-hidden px-6 py-10 sm:px-8 lg:px-12 lg:py-14">
        <div class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
            <div class="relative z-10">
                <p class="eyebrow">{{ $marketCity }} · {{ data_get($site, 'country') }}</p>
                <h1 class="page-title mt-5">
                    Des Abyssins eleves pres de
                    <span class="text-amber-700">{{ $marketCity }}</span>,
                    avec
                    <span class="text-amber-700">clarte, douceur et exigence</span>
                </h1>
                <p class="body-copy mt-6 max-w-2xl">
                    {{ config('chatterie.site.meta_description') }}
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('cats.index') }}" class="btn-primary">Voir les chats disponibles</a>
                    <a href="{{ route('contact') }}" class="btn-secondary">Parler de votre projet d'adoption</a>
                </div>
                <div class="mt-10 grid gap-4 sm:grid-cols-3">
                    <div class="metric-card">
                        <p class="eyebrow">Sante</p>
                        <span class="metric-value">Suivie</span>
                        <p class="subtle-text mt-3">Des informations claires sur chaque chat et son evolution.</p>
                    </div>
                    <div class="metric-card">
                        <p class="eyebrow">Cadre</p>
                        <span class="metric-value">Familial</span>
                        <p class="subtle-text mt-3">Socialisation quotidienne dans un environnement calme.</p>
                    </div>
                    <div class="metric-card">
                        <p class="eyebrow">Adoption</p>
                        <span class="metric-value">Accompagnee</span>
                        <p class="subtle-text mt-3">Un echange humain avant et apres l'arrivee au foyer.</p>
                    </div>
                </div>
            </div>

            <div class="relative mx-auto w-full max-w-xl">
                <div class="luminous-panel hero-glow p-6 sm:p-8">
                    <div class="mx-auto max-w-md">
                        <img src="{{ $logoAsset }}" alt="Embleme de la chatterie" class="hero-emblem mx-auto w-full max-w-[26rem]">
                    </div>
                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-[1.6rem] bg-white/12 px-5 py-4 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.24em] text-white/70">Race</p>
                            <p class="mt-2 font-display text-3xl">Abyssin</p>
                        </div>
                        <div class="rounded-[1.6rem] bg-white/12 px-5 py-4 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.24em] text-white/70">Disponibilites</p>
                            <p class="mt-2 font-display text-3xl">Claires</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-12 grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
        <article class="section-card p-8">
            <p class="eyebrow">Notre approche</p>
            <h2 class="section-title mt-4">Un elevage familial, lisible et rassurant</h2>
            <p class="body-copy mt-5">
                Nous mettons l'accent sur le temperament, le rythme de croissance, la socialisation et
                la qualite du lien avec les futurs adoptants. Chaque fiche publique presente l'essentiel
                de maniere simple pour vous aider a vous projeter sereinement.
            </p>
            @if ($serviceAreas !== [])
                <p class="subtle-text mt-5">
                    Zone de contact habituelle : {{ implode(', ', $serviceAreas) }}.
                </p>
            @endif
            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="detail-pill">
                    <p class="eyebrow">Presentation</p>
                    <p class="mt-2 text-lg font-semibold text-amber-950">Profils detailes</p>
                    <p class="subtle-text mt-2">Statut, age, robe, galerie et contact direct sont visibles rapidement.</p>
                </div>
                <div class="detail-pill">
                    <p class="eyebrow">Accompagnement</p>
                    <p class="mt-2 text-lg font-semibold text-amber-950">Echange humain</p>
                    <p class="subtle-text mt-2">Nous prenons le temps d'echanger avant toute decision d'adoption.</p>
                </div>
            </div>
        </article>

        <article class="luminous-panel p-8">
            <p class="text-sm uppercase tracking-[0.26em] text-white/65">Pourquoi l'Abyssin ?</p>
            <h2 class="mt-4 font-display text-5xl leading-tight text-white">Un chat vif, elegant et tres proche de l'humain</h2>
            <p class="mt-5 max-w-xl text-sm leading-7 text-white/78">
                L'Abyssin se distingue par son intelligence, son energie, sa curiosite et sa grande
                presence dans la vie du foyer. Il demande attention, interactions et environnement adapte.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <span class="tag-chip border-white/20 bg-white/10 text-white">Sociable</span>
                <span class="tag-chip border-white/20 bg-white/10 text-white">Curieux</span>
                <span class="tag-chip border-white/20 bg-white/10 text-white">Athletique</span>
            </div>
        </article>
    </section>

    <section class="mt-14">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="eyebrow">Disponibilites</p>
                <h2 class="section-title mt-3">Les profils actuellement visibles</h2>
                <p class="subtle-text mt-3 max-w-2xl">
                    Nous affichons ici en priorite les chats disponibles afin de garder une lecture claire
                    pour les familles en recherche active.
                </p>
            </div>
            <a href="{{ route('cats.index') }}" class="btn-secondary">Voir toutes les disponibilites</a>
        </div>

        @if ($featuredCats->isEmpty())
            <div class="section-card mt-6 p-10 text-center text-stone-500">
                Aucun chat disponible pour le moment.
            </div>
        @else
            <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($featuredCats as $cat)
                    <a href="{{ route('cats.show', $cat) }}" class="cat-card cat-card-link group flex h-full flex-col" aria-label="Voir la fiche de {{ $cat->name }}">
                        <div class="cat-card-media aspect-[4/3.5]">
                            @if ($cat->image)
                                <img src="{{ asset('storage/' . $cat->image) }}" alt="Portrait de {{ $cat->name }}" class="featured-portrait h-full w-full object-cover" loading="lazy" decoding="async">
                            @else
                                <div class="flex h-full items-center justify-center px-8 text-center text-sm font-semibold text-white/80">Portrait a venir</div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-3xl leading-tight font-semibold text-amber-950 transition group-hover:text-amber-800">{{ $cat->name }}</p>
                                    <p class="mt-1 text-sm text-amber-700">{{ $cat->category?->name ?? 'Lignee orientale' }}</p>
                                </div>
                                <x-status-badge :status="$cat->status" class="shrink-0" />
                            </div>

                            <p class="subtle-text mt-4">
                                {{ $cat->gender_label }} · {{ $cat->display_age ?? 'Age non renseigne' }} · {{ $cat->color ?? 'Robe non renseignee' }}
                            </p>
                            <p class="subtle-text mt-3">
                                {{ Str::limit($cat->description ?: "Une silhouette elegante, un regard vif et une presence lumineuse digne de la chatterie.", 110) }}
                            </p>

                            <div class="mt-5 flex items-center justify-between gap-3 border-t border-amber-100 pt-4">
                                <span class="min-w-0 truncate text-sm text-stone-600">{{ $cat->display_age ?? 'Age non renseigne' }}</span>
                                <span class="btn-ghost shrink-0 px-0 text-amber-900">Voir details</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    <section class="mt-14">
        <div class="mb-6">
            <p class="eyebrow">Nos engagements</p>
            <h2 class="section-title mt-3">Ce que nous voulons rendre evident sur le site</h2>
        </div>
        <div class="grid gap-4 lg:grid-cols-3">
            @foreach ($commitments as $commitment)
                <article class="metric-card">
                    <p class="eyebrow">Engagement</p>
                    <p class="mt-4 text-lg font-semibold text-amber-950">{{ $commitment }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mt-14">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="eyebrow">Guides pratiques</p>
                <h2 class="section-title mt-3">Des contenus utiles avant une prise de contact</h2>
            </div>
            <a href="{{ route('contact') }}" class="btn-ghost px-0">Parler de votre projet</a>
        </div>
        <div class="grid gap-6 xl:grid-cols-3">
            <article class="section-card p-8">
                <p class="eyebrow">Adoption locale</p>
                    <h3 class="mt-3 text-4xl font-semibold text-amber-950">Adopter un chaton Abyssin proche de Vannes</h3>
                <p class="subtle-text mt-4">
                    Un guide simple pour preparer votre foyer, poser les bonnes questions et mieux comprendre
                    ce qu'implique une adoption reussie.
                </p>
                <div class="mt-6">
                    <a href="{{ route('guides.adoption') }}" class="btn-secondary">Lire le guide</a>
                </div>
            </article>
            <article class="section-card p-8">
                <p class="eyebrow">Race</p>
                <h3 class="mt-3 text-4xl font-semibold text-amber-950">Comprendre le caractere du chat Abyssin</h3>
                <p class="subtle-text mt-4">
                    Un contenu utile pour savoir si l'Abyssin correspond vraiment a votre rythme de vie et
                    au type de compagnon que vous recherchez.
                </p>
                <div class="mt-6">
                    <a href="{{ route('guides.breed') }}" class="btn-secondary">Lire le guide</a>
                </div>
            </article>
            <article class="section-card p-8">
                <p class="eyebrow">Local SEO</p>
                <h3 class="mt-3 text-4xl font-semibold text-amber-950">Elevage Abyssin dans le Morbihan</h3>
                <p class="subtle-text mt-4">
                    Une page locale claire pour les recherches autour de Saint-Ave, Vannes et du Morbihan.
                </p>
                <div class="mt-6">
                    <a href="{{ route('guides.local') }}" class="btn-secondary">Lire le guide</a>
                </div>
            </article>
        </div>
    </section>

    <section class="mt-14">
        <div class="section-card px-6 py-10 text-center sm:px-10">
            <p class="eyebrow">Adoption & contact</p>
            <h2 class="section-title mt-3">Parlons de votre futur compagnon</h2>
            <p class="subtle-text mx-auto mt-4 max-w-2xl">
                Si vous souhaitez adopter, reserver ou simplement comprendre le caractere d'un profil,
                nous restons disponibles pour un echange clair et bienveillant.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('contact') }}" class="btn-primary">Nous contacter</a>
                <a href="{{ route('about') }}" class="btn-secondary">A propos de l'elevage</a>
            </div>
        </div>
    </section>

    @if ($faqItems !== [])
        <section class="mt-14">
            <div class="mb-6">
                <p class="eyebrow">Questions frequentes</p>
                <h2 class="section-title mt-3">Les reponses les plus utiles avant un premier echange</h2>
            </div>
            <div class="grid gap-4">
                @foreach ($faqItems as $faq)
                    <article class="section-card p-6">
                        <h3 class="text-2xl font-semibold text-amber-950">{{ $faq['question'] }}</h3>
                        <p class="subtle-text mt-3">{{ $faq['answer'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
@endsection

@push('structured_data')
    <script type="application/ld+json">@json($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
@endpush
