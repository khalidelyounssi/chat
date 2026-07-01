@extends('layouts.public')

@section('title', 'A propos de la chatterie d\'Abyssins - Chatterie des Soleils d\'Orient')
@section('meta_description', 'Presentation de la chatterie, de son approche familiale, de la socialisation des Abyssins et de l\'accompagnement a l\'adoption.')
@section('canonical', route('about'))

@section('content')
    @php
        $site = config('chatterie.site');
        $logoPath = 'images/soleils-orient-emblem.png';
        $logoVersion = file_exists(public_path($logoPath)) ? filemtime(public_path($logoPath)) : null;
        $logoAsset = asset($logoPath) . ($logoVersion ? '?v=' . $logoVersion : '');
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
                <img src="{{ $logoAsset }}" alt="Identite visuelle de la chatterie" class="w-full">
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

    <section id="avis" class="mt-12 scroll-mt-36">
        <div class="section-card overflow-hidden">
            <div class="grid lg:grid-cols-[0.95fr_1.05fr]">
                <div class="border-b border-amber-100 px-6 py-9 sm:px-9 lg:border-b-0 lg:border-r lg:py-10">
                    <div class="flex flex-wrap items-end justify-between gap-5">
                        <div>
                            <p class="eyebrow">Avis des familles</p>
                            <h2 class="section-title mt-3">Leurs mots comptent</h2>
                        </div>
                        @if ($averageRating)
                            <div class="review-summary" aria-label="Note moyenne de {{ $averageRating }} sur 5">
                                <span class="font-display text-5xl text-amber-950">{{ number_format($averageRating, 1, ',', '') }}</span>
                                <span class="review-stars" aria-hidden="true">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                                <span class="text-xs text-stone-500">{{ $reviewCount }} {{ $reviewCount === 1 ? 'avis publie' : 'avis publies' }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="mt-7 grid gap-4">
                        @forelse ($reviews as $review)
                            <article class="review-card">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="font-semibold text-amber-950">{{ $review->name }}</p>
                                        <p class="mt-1 text-xs text-stone-500">{{ $review->approved_at?->translatedFormat('F Y') }}</p>
                                    </div>
                                    <div class="review-stars" aria-label="{{ $review->rating }} etoiles sur 5">
                                        @for ($star = 1; $star <= 5; $star++)
                                            <span class="{{ $star > $review->rating ? 'review-star-muted' : '' }}">&#9733;</span>
                                        @endfor
                                    </div>
                                </div>
                                <p class="mt-4 text-sm leading-7 text-stone-700">&ldquo;{{ $review->comment }}&rdquo;</p>
                            </article>
                        @empty
                            <div class="rounded-[1.5rem] border border-dashed border-amber-200 bg-amber-50/50 p-6">
                                <p class="font-display text-3xl text-amber-950">Soyez la premiere famille a partager son experience.</p>
                                <p class="subtle-text mt-2">Votre avis apparaitra ici apres une verification rapide.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-amber-50/45 px-6 py-9 sm:px-9 lg:py-10">
                    <p class="eyebrow">Partager votre experience</p>
                    <h3 class="mt-3 font-display text-4xl font-semibold text-amber-950">Laisser un avis</h3>
                    <p class="subtle-text mt-3">Quelques mots suffisent. Votre avis sera relu avant sa publication.</p>

                    <form action="{{ route('reviews.store') }}#avis" method="POST" class="mt-7 grid gap-5">
                        @csrf

                        <div class="hidden" aria-hidden="true">
                            <label for="website">Site web</label>
                            <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                        </div>

                        <div>
                            <label for="review-name" class="label-base">Votre prenom ou votre nom</label>
                            <input
                                id="review-name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                maxlength="100"
                                autocomplete="name"
                                class="input-base"
                                placeholder="Ex. Sophie"
                                required
                            >
                        </div>

                        <fieldset>
                            <legend class="label-base">Votre note</legend>
                            <div class="rating-input" aria-label="Choisir une note sur 5">
                                @for ($rating = 5; $rating >= 1; $rating--)
                                    <input
                                        id="rating-{{ $rating }}"
                                        name="rating"
                                        type="radio"
                                        value="{{ $rating }}"
                                        {{ (int) old('rating') === $rating ? 'checked' : '' }}
                                        required
                                    >
                                    <label for="rating-{{ $rating }}" title="{{ $rating }} etoiles">
                                        <span class="sr-only">{{ $rating }} etoiles</span>&#9733;
                                    </label>
                                @endfor
                            </div>
                        </fieldset>

                        <div>
                            <label for="review-comment" class="label-base">Votre commentaire</label>
                            <textarea
                                id="review-comment"
                                name="comment"
                                rows="5"
                                minlength="10"
                                maxlength="1200"
                                class="input-base resize-y"
                                placeholder="Racontez votre experience avec la chatterie..."
                                required
                            >{{ old('comment') }}</textarea>
                        </div>

                        <button type="submit" class="btn-primary w-full sm:w-auto sm:justify-self-start">Envoyer mon avis</button>
                    </form>
                </div>
            </div>
        </div>
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
