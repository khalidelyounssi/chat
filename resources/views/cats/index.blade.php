@extends('layouts.public')

@section('title', 'Nos chats - Chatterie des Soleils d\'Orient')

@section('content')
    @php
        use Illuminate\Support\Str;

        $whatsAppNumber = preg_replace('/\D+/', '', (string) config('chatterie.whatsapp.number'));
        $contactLink = $whatsAppNumber ? 'https://wa.me/' . $whatsAppNumber : route('about');
    @endphp

    <section class="hero-glow glass-panel overflow-hidden px-6 py-10 sm:px-8 lg:px-12">
        <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-end">
            <div>
                <p class="eyebrow">Nos chats</p>
                <h1 class="page-title mt-4">Nos Compagnons</h1>
                <p class="body-copy mt-6 max-w-2xl">
                    Decouvrez la noblesse et la douceur de nos Abyssins. Chaque profil reprend l'esprit
                    lumineux, dore et editorial de votre maquette, sans perdre les donnees reelles du projet.
                </p>
            </div>

            <div class="section-card p-5 sm:p-6">
                <form method="GET" action="{{ route('cats.index') }}" class="grid gap-4 sm:grid-cols-[1fr_auto] sm:items-end">
                    <div>
                        <label for="categorie" class="eyebrow">Lignee / categorie</label>
                        <select id="categorie" name="categorie" class="filter-select mt-3">
                            <option value="">Toutes les categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}" @selected($selectedCategorySlug === $category->slug)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn-primary">Filtrer</button>
                </form>

                @if ($selectedCategory)
                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <span class="tag-chip">Filtre actif: {{ $selectedCategory->name }}</span>
                        <a href="{{ route('cats.index') }}" class="btn-ghost px-0">Reinitialiser</a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if ($invalidCategory)
        <div class="mt-6 rounded-[1.5rem] border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-800">
            La categorie demandee n'existe pas.
        </div>
    @endif

    <section class="mt-12">
        @if ($cats->isEmpty())
            <div class="section-card p-10 text-center text-stone-500">
                Aucun chat trouve pour le moment.
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($cats as $cat)
                    <article class="cat-card flex h-full flex-col">
                        <div class="cat-card-media aspect-[4/3.6]">
                            @if ($cat->image)
                                <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center text-sm font-semibold text-white/80">Image a venir</div>
                            @endif
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <h2 class="text-3xl leading-tight font-semibold text-amber-950 sm:text-[2.2rem]">
                                        {{ $cat->name }}
                                    </h2>
                                    <p class="mt-1 text-sm text-amber-700">
                                        {{ $cat->breed }}{{ $cat->color ? ' · ' . $cat->color : '' }}
                                    </p>
                                </div>
                                <x-status-badge :status="$cat->status" class="shrink-0" />
                            </div>

                            <p class="subtle-text mt-4">
                                {{ Str::limit($cat->description ?: "Un Abyssin au regard solaire, eleve dans un cadre familial avec toute l'attention qu'il merite.", 110) }}
                            </p>

                            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                <div class="detail-pill">
                                    <p class="eyebrow">Age</p>
                                    <p class="mt-2 text-lg font-semibold text-amber-950">{{ $cat->display_age ?? 'Non renseigne' }}</p>
                                </div>
                                <div class="detail-pill">
                                    <p class="eyebrow">Genre</p>
                                    <p class="mt-2 text-lg font-semibold text-amber-950">{{ $cat->gender_label }}</p>
                                </div>
                            </div>

                            <div class="mt-5 flex items-center justify-between gap-3 border-t border-amber-100 pt-4">
                                <span class="min-w-0 truncate text-sm text-stone-600">{{ $cat->category?->name ?? 'Sans categorie' }}</span>
                                <a href="{{ route('cats.show', $cat) }}" class="btn-ghost shrink-0 px-0">En savoir plus</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $cats->links() }}
            </div>
        @endif
    </section>

    <section class="mt-14">
        <div class="luminous-panel p-8 sm:p-10">
            <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-white/65">Adoption</p>
                    <h2 class="mt-4 font-display text-5xl leading-tight text-white">Adopter l'un de nos tresors ?</h2>
                    <p class="mt-4 max-w-2xl text-sm leading-7 text-white/78">
                        Nous selectionnons avec soin les futurs foyers et restons disponibles pour echanger
                        autour du caractere, des besoins et du rythme de vie de chaque chat.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3 lg:justify-end">
                    <a href="{{ route('about') }}" class="btn-secondary border-white/15 bg-white text-amber-900">A propos</a>
                    <a href="{{ $contactLink }}" class="btn-primary">Nous contacter</a>
                </div>
            </div>
        </div>
    </section>
@endsection
