@extends('layouts.public')

@section('title', "Avis clients - Chatterie des Soleils d'Orient")
@section('meta_description', "Consultez les avis des familles et partagez votre experience avec la Chatterie des Soleils d'Orient.")
@section('canonical', route('reviews'))

@section('content')
    @php
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
                    'name' => 'Avis',
                    'item' => route('reviews'),
                ],
            ],
        ];
    @endphp

    <section class="hero-glow glass-panel overflow-hidden px-6 py-10 sm:px-8 lg:px-12">
        <div class="max-w-3xl">
            <p class="eyebrow">Avis des familles</p>
            <h1 class="page-title mt-4">Vos experiences, en toute simplicite</h1>
            <p class="body-copy mt-6 max-w-2xl">
                Decouvrez les retours partages par les familles et laissez quelques mots sur votre experience
                avec la chatterie. Chaque avis est verifie avant sa publication.
            </p>
        </div>
    </section>

    <section class="mt-12">
        <div class="section-card overflow-hidden">
            <div class="grid lg:grid-cols-[1.08fr_0.92fr]">
                <div class="border-b border-amber-100 px-6 py-9 sm:px-9 lg:border-b-0 lg:border-r lg:py-10">
                    <div class="flex flex-wrap items-end justify-between gap-5">
                        <div>
                            <p class="eyebrow">Temoignages</p>
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

                    <div class="mt-7 grid gap-4 sm:grid-cols-2">
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
                            <div class="rounded-[1.5rem] border border-dashed border-amber-200 bg-amber-50/50 p-6 sm:col-span-2">
                                <p class="font-display text-3xl text-amber-950">Soyez la premiere famille a partager son experience.</p>
                                <p class="subtle-text mt-2">Votre avis apparaitra ici apres une verification rapide.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div id="laisser-un-avis" class="scroll-mt-36 bg-amber-50/45 px-6 py-9 sm:px-9 lg:py-10">
                    <p class="eyebrow">Partager votre experience</p>
                    <h2 class="mt-3 font-display text-4xl font-semibold text-amber-950">Laisser un avis</h2>
                    <p class="subtle-text mt-3">Quelques mots suffisent. Votre avis sera relu avant sa publication.</p>

                    <form action="{{ route('reviews.store') }}#laisser-un-avis" method="POST" class="mt-7 grid gap-5">
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
@endsection

@push('structured_data')
    <script type="application/ld+json">@json($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
@endpush
