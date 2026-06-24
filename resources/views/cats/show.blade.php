@extends('layouts.public')

@section('title', $cat->name . " - Chatterie des Soleils d'Orient")
@section('meta_description', $cat->description ? \Illuminate\Support\Str::limit($cat->description, 150) : "Decouvrez le profil de {$cat->name}, Abyssin presente par la chatterie.")

@section('content')
    @php
        use Illuminate\Support\Str;

        $whatsAppNumber = preg_replace('/\D+/', '', (string) config('chatterie.whatsapp.number'));
        $directWhatsAppLink = strlen($whatsAppNumber) >= 8
            ? 'https://wa.me/' . $whatsAppNumber . '?text=' . rawurlencode($whatsappMessage)
            : route('contact');
        $adoptionSteps = config('chatterie.adoption_steps', []);
    @endphp

    <a href="{{ route('cats.index') }}" class="btn-ghost mb-5 px-0">&larr; Retour a la liste</a>

    <section class="glass-panel overflow-hidden p-5 sm:p-6 lg:p-8">
        <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr]">
            <div class="detail-portrait">
                @if ($cat->image)
                    <button
                        type="button"
                        class="image-lightbox-trigger h-full w-full cursor-zoom-in"
                        data-lightbox-trigger
                        data-lightbox-src="{{ asset('storage/' . $cat->image) }}"
                        data-lightbox-alt="Portrait de {{ $cat->name }}"
                        data-lightbox-caption="{{ $cat->name }}{{ $cat->color ? ' · ' . $cat->color : '' }}"
                    >
                        <img src="{{ asset('storage/' . $cat->image) }}" alt="Portrait de {{ $cat->name }}" class="h-full min-h-[440px] w-full object-cover">
                    </button>
                @else
                    <div class="flex min-h-[440px] items-center justify-center text-amber-800">Image indisponible</div>
                @endif
            </div>

            <div class="flex flex-col justify-between">
                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="tag-chip">{{ $cat->category?->name ?? 'Lignee orientale' }}</span>
                        <x-status-badge :status="$cat->status" />
                    </div>

                    @if ($cat->status === 'reserved')
                        <div class="mt-4 rounded-[1.3rem] border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                            Ce profil est actuellement reserve. Vous pouvez toutefois nous contacter pour etre informe d'un changement ou d'un autre profil similaire.
                        </div>
                    @endif

                    <h1 class="mt-5 text-5xl font-semibold leading-none text-amber-950 sm:text-6xl">{{ $cat->name }}</h1>
                    <p class="mt-3 font-display text-2xl italic text-amber-800">
                        {{ $cat->breed }}{{ $cat->color ? ' - ' . $cat->color : '' }}
                    </p>

                    <div class="mt-7 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                        <div class="detail-pill">
                            <p class="eyebrow">Age</p>
                            <p class="mt-2 text-lg font-semibold text-amber-950">{{ $cat->display_age ?? 'Non renseigne' }}</p>
                        </div>
                        <div class="detail-pill">
                            <p class="eyebrow">Genre</p>
                            <p class="mt-2 text-lg font-semibold text-amber-950">{{ $cat->gender_label }}</p>
                        </div>
                        <div class="detail-pill">
                            <p class="eyebrow">Poids</p>
                            <p class="mt-2 text-lg font-semibold text-amber-950">{{ $cat->weight ? $cat->weight . ' kg' : 'Non renseigne' }}</p>
                        </div>
                    </div>

                    <div class="mt-7 space-y-5">
                        <p class="body-copy">
                            {{ $cat->description ?: "Ce profil presente l'essentiel pour une premiere prise de contact : temperament, statut, age et informations utiles pour preparer l'adoption." }}
                        </p>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="detail-pill">
                                <p class="eyebrow">Date de naissance</p>
                                <p class="mt-2 text-[1.02rem] font-semibold text-amber-950">{{ $cat->birth_date ? $cat->birth_date->format('d/m/Y') : 'Non renseignee' }}</p>
                            </div>
                            <div class="detail-pill">
                                <p class="eyebrow">Couleur</p>
                                <p class="mt-2 text-[1.02rem] font-semibold text-amber-950">{{ $cat->color ?? 'Non renseignee' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid gap-3 sm:grid-cols-2">
                    @if (strlen($whatsAppNumber) >= 8)
                        <a href="{{ $directWhatsAppLink }}" target="_blank" rel="noopener noreferrer" class="btn-primary">
                            Contactez-nous via WhatsApp
                        </a>
                    @else
                        <a href="{{ route('contact') }}" class="btn-primary">
                            Nous contacter
                        </a>
                    @endif
                    <a href="{{ route('cats.index') }}" class="btn-secondary">Voir les autres chats</a>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-12 grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
        <article class="section-card p-8">
            <p class="eyebrow">Portrait</p>
            <h2 class="section-title mt-4">Une fiche claire pour une decision plus sereine</h2>
            <p class="body-copy mt-5">
                Nous presentons ici les informations essentielles utiles a une premiere evaluation :
                categorie, statut, age, robe, poids, galerie et moyen de contact rapide.
            </p>
            <div class="mt-7 flex flex-wrap gap-3">
                <span class="tag-chip">{{ config('chatterie.statuses.' . $cat->status) }}</span>
                <span class="tag-chip">{{ $cat->gender_label }}</span>
                <span class="tag-chip">Contact rapide</span>
            </div>
        </article>

        <article class="luminous-panel p-8">
            <p class="luminous-label">Avant l'adoption</p>
            <h2 class="mt-4 font-display text-5xl leading-tight text-white">Comment se passe la suite ?</h2>
            <div class="mt-5 grid gap-3">
                @foreach ($adoptionSteps as $index => $step)
                    <div class="rounded-[1.5rem] bg-white/10 px-5 py-4 backdrop-blur-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-white/75">Etape {{ $index + 1 }}</p>
                        <p class="luminous-copy mt-2">{{ $step }}</p>
                    </div>
                @endforeach
            </div>
        </article>
    </section>

    @if (is_array($cat->gallery) && count($cat->gallery) > 0)
        <section class="mt-12">
            <div class="mb-6">
                <p class="eyebrow">Instants de lumiere</p>
                <h2 class="section-title mt-3">Galerie de {{ $cat->name }}</h2>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($cat->gallery as $image)
                    <div class="gallery-tile">
                        <button
                            type="button"
                            class="image-lightbox-trigger h-full w-full cursor-zoom-in"
                            data-lightbox-trigger
                            data-lightbox-src="{{ asset('storage/' . $image) }}"
                            data-lightbox-alt="Galerie de {{ $cat->name }}"
                            data-lightbox-caption="Galerie de {{ $cat->name }}"
                        >
                            <img src="{{ asset('storage/' . $image) }}" alt="Galerie de {{ $cat->name }}" class="h-64 w-full object-cover" loading="lazy" decoding="async">
                        </button>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if ($relatedCats->isNotEmpty())
        <section class="mt-12">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="eyebrow">Autres profils</p>
                    <h2 class="section-title mt-3">Decouvrir aussi</h2>
                </div>
                <a href="{{ route('cats.index') }}" class="btn-secondary">Retour au catalogue</a>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($relatedCats as $relatedCat)
                    <a href="{{ route('cats.show', $relatedCat) }}" class="cat-card cat-card-link group flex h-full flex-col" aria-label="Voir la fiche de {{ $relatedCat->name }}">
                        <div class="cat-card-media aspect-[4/3.5]">
                            @if ($relatedCat->image)
                                <img src="{{ asset('storage/' . $relatedCat->image) }}" alt="Portrait de {{ $relatedCat->name }}" class="featured-portrait h-full w-full object-cover" loading="lazy" decoding="async">
                            @else
                                <div class="flex h-full items-center justify-center px-8 text-center text-sm font-semibold text-white/80">Portrait a venir</div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-3xl leading-tight font-semibold text-amber-950 transition group-hover:text-amber-800">{{ $relatedCat->name }}</p>
                                    <p class="mt-1 text-sm text-amber-700">{{ $relatedCat->category?->name ?? 'Abyssin' }}</p>
                                </div>
                                <x-status-badge :status="$relatedCat->status" class="shrink-0" />
                            </div>

                            <p class="subtle-text mt-4">
                                {{ Str::limit($relatedCat->description ?: "Un profil a decouvrir selon vos attentes et votre rythme de vie.", 100) }}
                            </p>

                            <div class="mt-5 flex items-center justify-between gap-3 border-t border-amber-100 pt-4">
                                <span class="min-w-0 truncate text-sm text-stone-600">{{ $relatedCat->gender_label }}</span>
                                <span class="btn-ghost shrink-0 px-0 text-amber-900">Voir details</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection
