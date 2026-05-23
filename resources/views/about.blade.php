@extends('layouts.public')

@section('title', 'A propos - Chatterie des Soleils d\'Orient')

@section('content')
    <section class="hero-glow glass-panel overflow-hidden px-6 py-10 sm:px-8 lg:px-12">
        <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
            <div class="mx-auto w-full max-w-md">
                <img src="{{ asset('images/soleils-orient-emblem.png') }}" alt="Soleils d'Orient" class="w-full">
            </div>
            <div>
                <p class="eyebrow">A propos</p>
                <h1 class="page-title mt-4">Une chatterie de lumiere</h1>
                <p class="body-copy mt-6 max-w-2xl">
                    L'Abyssin est un chat vif, elegant et profondement attache a son humain. Notre chatterie
                    s'articule autour d'un elevage responsable, d'un environnement doux et d'une presentation
                    plus haut de gamme, en accord avec l'univers graphique que vous avez partage.
                </p>
            </div>
        </div>
    </section>

    <section class="mt-12 grid gap-6 md:grid-cols-3">
        <article class="section-card p-6">
            <p class="eyebrow">Caractere</p>
            <h2 class="mt-3 text-4xl font-semibold text-amber-950">Curieux et tendre</h2>
            <p class="subtle-text mt-4">
                L'Abyssin aime l'interaction, observe tout et cree un lien tres fort avec sa famille.
            </p>
        </article>
        <article class="section-card p-6">
            <p class="eyebrow">Sante</p>
            <h2 class="mt-3 text-4xl font-semibold text-amber-950">Suivi rigoureux</h2>
            <p class="subtle-text mt-4">
                Nous privilegions la prevention, la qualite de vie et un cadre de croissance stable.
            </p>
        </article>
        <article class="section-card p-6">
            <p class="eyebrow">Socialisation</p>
            <h2 class="mt-3 text-4xl font-semibold text-amber-950">Equilibre familial</h2>
            <p class="subtle-text mt-4">
                Les chatons grandissent dans un environnement humain, doux et rassurant.
            </p>
        </article>
    </section>
@endsection
