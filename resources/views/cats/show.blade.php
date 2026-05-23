@extends('layouts.public')

@section('title', $cat->name . " - Chatterie des Soleils d'Orient")

@section('content')
    @php
        $whatsAppNumber = preg_replace('/\D+/', '', (string) config('chatterie.whatsapp.number'));
        $directWhatsAppLink = $whatsAppNumber
            ? 'https://wa.me/' . $whatsAppNumber . '?text=' . rawurlencode($whatsappMessage)
            : '#';
    @endphp

    <a href="{{ route('cats.index') }}" class="btn-ghost mb-5 px-0">&larr; Retour a la liste</a>

    <section class="glass-panel overflow-hidden p-5 sm:p-6 lg:p-8">
        <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr]">
            <div class="overflow-hidden rounded-[2rem] bg-amber-100 shadow-[0_24px_60px_rgba(92,56,6,0.18)]">
                @if ($cat->image)
                    <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" class="h-full min-h-[440px] w-full object-cover">
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

                    <h1 class="mt-5 text-5xl font-semibold leading-none text-amber-950 sm:text-6xl">{{ $cat->name }}</h1>
                    <p class="mt-3 font-display text-2xl italic text-amber-700">
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
                            {{ $cat->description ?: "Ce chat incarne l'elegance orientale, la curiosite vive et la douceur de la chatterie. Son profil pourra etre complete avec plus de details selon vos besoins." }}
                        </p>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="detail-pill">
                                <p class="eyebrow">Date de naissance</p>
                                <p class="mt-2 text-base font-semibold text-amber-950">{{ $cat->birth_date ? $cat->birth_date->format('d/m/Y') : 'Non renseignee' }}</p>
                            </div>
                            <div class="detail-pill">
                                <p class="eyebrow">Couleur</p>
                                <p class="mt-2 text-base font-semibold text-amber-950">{{ $cat->color ?? 'Non renseignee' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid gap-3 sm:grid-cols-2">
                    @if ($whatsAppNumber)
                        <a href="{{ $directWhatsAppLink }}" target="_blank" rel="noopener noreferrer" class="btn-primary">
                            Contactez-nous via WhatsApp
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
            <h2 class="section-title mt-4">L'eclat d'un compagnon d'exception</h2>
            <p class="body-copy mt-5">
                Chaque fiche reprend une presentation plus precieuse et plus narrative, inspiree de votre maquette.
                Nous gardons ici les vraies informations du projet: categorie, age, robe, genre et description.
            </p>
            <div class="mt-7 flex flex-wrap gap-3">
                <span class="tag-chip">Lignee orientale</span>
                <span class="tag-chip">Presentation premium</span>
                <span class="tag-chip">Contact rapide</span>
            </div>
        </article>

        <article class="luminous-panel p-8">
            <p class="text-sm uppercase tracking-[0.24em] text-white/65">Accompagnement</p>
            <h2 class="mt-4 font-display text-5xl leading-tight text-white">Une relation simple et humaine</h2>
            <p class="mt-4 text-sm leading-7 text-white/78">
                Pour toute question sur le caractere, l'adoption ou la disponibilite de {{ $cat->name }},
                vous pouvez nous ecrire directement. Le ton visuel reste haut de gamme, mais l'echange reste chaleureux.
            </p>
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
                    <div class="overflow-hidden rounded-[1.8rem] border border-amber-100 bg-white shadow-[0_18px_42px_rgba(92,56,6,0.12)]">
                        <img src="{{ asset('storage/' . $image) }}" alt="Galerie {{ $cat->name }}" class="h-64 w-full object-cover">
                    </div>
                @endforeach
            </div>
        </section>
    @endif
@endsection
