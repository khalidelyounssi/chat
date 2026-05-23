@extends('layouts.public')

@section('title', "Chatterie des Soleils d'Orient")

@section('content')
    @php use Illuminate\Support\Str; @endphp

    <section class="hero-glow glass-panel overflow-hidden px-6 py-10 sm:px-8 lg:px-12 lg:py-14">
        <div class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
            <div class="relative z-10">
                <p class="eyebrow">Elevage d'exception</p>
                <h1 class="page-title mt-5">
                    Chatterie des <span class="text-amber-700">Soleils d'Orient</span>
                </h1>
                <p class="body-copy mt-6 max-w-2xl">
                    Une chatterie d'Abyssins pensee comme une maison de lumiere: l'elegance du regard,
                    la douceur du foyer et un accompagnement attentionne a chaque adoption.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('cats.index') }}" class="btn-primary">Voir nos chats</a>
                    <a href="{{ route('about') }}" class="btn-secondary">Decouvrir notre univers</a>
                </div>
                <div class="mt-10 grid gap-4 sm:grid-cols-3">
                    <div class="metric-card">
                        <p class="eyebrow">Esprit</p>
                        <span class="metric-value">Solaire</span>
                        <p class="subtle-text mt-3">Un elevage sensible, chaleureux et raffine.</p>
                    </div>
                    <div class="metric-card">
                        <p class="eyebrow">Race</p>
                        <span class="metric-value">Abyssin</span>
                        <p class="subtle-text mt-3">Grace feline, energie douce et intelligence vive.</p>
                    </div>
                    <div class="metric-card">
                        <p class="eyebrow">Contact</p>
                        <span class="metric-value">Direct</span>
                        <p class="subtle-text mt-3">Echanges simples via WhatsApp pour chaque projet.</p>
                    </div>
                </div>
            </div>

            <div class="relative mx-auto w-full max-w-xl">
                <div class="luminous-panel hero-glow p-6 sm:p-8">
                    <div class="mx-auto max-w-md">
                        <img src="{{ asset('images/soleils-orient-emblem.png') }}" alt="Embleme Soleils d'Orient" class="mx-auto w-full max-w-[26rem] drop-shadow-[0_24px_50px_rgba(255,208,111,0.28)]">
                    </div>
                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-[1.6rem] bg-white/12 px-5 py-4 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.24em] text-white/70">Lignee</p>
                            <p class="mt-2 font-display text-3xl">Prestige oriental</p>
                        </div>
                        <div class="rounded-[1.6rem] bg-white/12 px-5 py-4 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.24em] text-white/70">Ambiance</p>
                            <p class="mt-2 font-display text-3xl">Douceur doree</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-12 grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
        <article class="section-card p-8">
            <p class="eyebrow">L'esprit de la chatterie</p>
            <h2 class="section-title mt-4">Une passionnee aux doigts d'or</h2>
            <p class="body-copy mt-5">
                Nos Abyssins grandissent dans un cadre calme, lumineux et soigne. Nous privilegions
                la sante, le temperament et la qualite du lien humain pour former des compagnons
                aussi majestueux qu'attendrissants.
            </p>
            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="detail-pill">
                    <p class="eyebrow">Selection</p>
                    <p class="mt-2 text-lg font-semibold text-amber-950">Lignee de prestige</p>
                    <p class="subtle-text mt-2">Suivi responsable et presentation attentive de chaque profil.</p>
                </div>
                <div class="detail-pill">
                    <p class="eyebrow">Cadre</p>
                    <p class="mt-2 text-lg font-semibold text-amber-950">Maison familiale</p>
                    <p class="subtle-text mt-2">Socialisation, douceur et contact humain au quotidien.</p>
                </div>
            </div>
        </article>

        <article class="luminous-panel p-8">
            <p class="text-sm uppercase tracking-[0.26em] text-white/65">Lumiere d'Orient</p>
            <h2 class="mt-4 font-display text-5xl leading-tight text-white">Une presence noble, un coeur tendre</h2>
            <p class="mt-5 max-w-xl text-sm leading-7 text-white/78">
                L'Abyssin incarne l'equilibre parfait entre elegance athletique, douceur affectueuse
                et regard incandescent. Un chat de compagnie remarquable et intensement vivant.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <span class="tag-chip border-white/20 bg-white/10 text-white">Elegance naturelle</span>
                <span class="tag-chip border-white/20 bg-white/10 text-white">Socialisation douce</span>
                <span class="tag-chip border-white/20 bg-white/10 text-white">Accompagnement humain</span>
            </div>
        </article>
    </section>

    <section class="mt-14">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="eyebrow">Nos compagnons</p>
                <h2 class="section-title mt-3">La collection orientale</h2>
                <p class="subtle-text mt-3 max-w-2xl">
                    Decouvrez les chats disponibles presents avec une mise en scene plus premium, proche de votre maquette.
                </p>
            </div>
            <a href="{{ route('cats.index') }}" class="btn-secondary">Voir toute la galerie</a>
        </div>

        @if ($featuredCats->isEmpty())
            <div class="section-card mt-6 p-10 text-center text-stone-500">
                Aucun chat disponible pour le moment.
            </div>
        @else
            <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($featuredCats as $cat)
                    <article class="cat-card flex h-full flex-col">
                        <div class="cat-card-media aspect-[4/3.5]">
                            @if ($cat->image)
                                <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center px-8 text-center text-sm font-semibold text-white/80">Portrait a venir</div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-3xl leading-tight font-semibold text-amber-950">{{ $cat->name }}</p>
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

                            <div class="mt-5">
                                <a href="{{ route('cats.show', $cat) }}" class="btn-secondary w-full">Voir la fiche</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <section class="mt-14">
        <div class="section-card px-6 py-10 text-center sm:px-10">
            <p class="eyebrow">Adoption & contact</p>
            <h2 class="section-title mt-3">Commencons l'aventure ensemble</h2>
            <p class="subtle-text mx-auto mt-4 max-w-2xl">
                Pour adopter l'un de nos tresors ou obtenir plus d'informations sur la chatterie,
                nous restons disponibles pour vous accompagner avec douceur et clarte.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('cats.index') }}" class="btn-primary">Nos chats</a>
                <a href="{{ route('about') }}" class="btn-secondary">A propos de l'elevage</a>
            </div>
        </div>
    </section>
@endsection
