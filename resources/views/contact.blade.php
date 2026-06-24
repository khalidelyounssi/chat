@extends('layouts.public')

@section('title', 'Contact - Chatterie des Soleils d\'Orient')
@section('meta_description', 'Contactez la chatterie pour parler d\'adoption, de disponibilites, du caractere des Abyssins et de la preparation du foyer.')

@section('content')
    @php
        $site = config('chatterie.site');
        $adoptionSteps = config('chatterie.adoption_steps', []);
        $whatsAppNumber = preg_replace('/\D+/', '', (string) config('chatterie.whatsapp.number'));
        $whatsAppLink = strlen($whatsAppNumber) >= 8
            ? 'https://wa.me/' . $whatsAppNumber . '?text=' . rawurlencode((string) config('chatterie.whatsapp.default_text'))
            : null;
        $phone = (string) data_get($site, 'phone', '');
        $phoneLink = preg_replace('/[^+\d]/', '', $phone);
        $email = (string) data_get($site, 'email', '');
        $instagramUrl = (string) config('chatterie.socials.instagram', '');
        $ownerName = (string) data_get($site, 'owner_name', '');
    @endphp

    <section class="hero-glow glass-panel overflow-hidden px-6 py-10 sm:px-8 lg:px-12">
        <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
            <div>
                <p class="eyebrow">Contact</p>
                <h1 class="page-title mt-4">Parlons de votre projet d'adoption</h1>
                <p class="body-copy mt-6 max-w-2xl">
                    Nous privilegions un premier echange simple pour comprendre votre foyer, vos habitudes
                    et le type de compagnon que vous recherchez. Vous pouvez nous ecrire via WhatsApp,
                    par telephone ou par e-mail selon ce qui vous convient le mieux.
                </p>
                @if ($ownerName !== '')
                    <p class="mt-4 text-sm font-semibold uppercase tracking-[0.18em] text-amber-800/70">
                        Contact principal : {{ $ownerName }}
                    </p>
                @endif
                <div class="mt-8 flex flex-wrap gap-3">
                    @if ($whatsAppLink)
                        <a href="{{ $whatsAppLink }}" target="_blank" rel="noopener noreferrer" class="btn-primary">WhatsApp</a>
                    @endif
                    @if ($phone !== '')
                        <a href="{{ $phoneLink ? 'tel:' . $phoneLink : '#' }}" class="btn-secondary">Appeler</a>
                    @endif
                    @if ($email !== '')
                        <a href="mailto:{{ $email }}" class="btn-secondary">Envoyer un e-mail</a>
                    @endif
                </div>
            </div>

            <div class="section-card p-6 sm:p-8">
                <p class="eyebrow">Coordonnees</p>
                <div class="mt-5 grid gap-4">
                    @if ($ownerName !== '')
                        <div class="detail-pill">
                            <p class="eyebrow">Proprietaire</p>
                            <p class="mt-2 text-lg font-semibold text-amber-950">{{ $ownerName }}</p>
                        </div>
                    @endif

                    @if ($phone !== '')
                        <div class="detail-pill">
                            <p class="eyebrow">Telephone</p>
                            <a href="{{ $phoneLink ? 'tel:' . $phoneLink : '#' }}" class="mt-2 block text-lg font-semibold text-amber-950">{{ $phone }}</a>
                        </div>
                    @endif

                    @if ($email !== '')
                        <div class="detail-pill">
                            <p class="eyebrow">E-mail</p>
                            <a href="mailto:{{ $email }}" class="mt-2 block text-lg font-semibold text-amber-950">{{ $email }}</a>
                        </div>
                    @endif

                    <div class="detail-pill">
                        <p class="eyebrow">Localisation</p>
                        <p class="mt-2 text-lg font-semibold text-amber-950">{{ data_get($site, 'address') }}</p>
                        <p class="subtle-text mt-2">{{ data_get($site, 'hours') }}</p>
                    </div>

                    @if ($instagramUrl !== '')
                        <div class="detail-pill">
                            <p class="eyebrow">Instagram</p>
                            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="mt-2 block text-lg font-semibold text-amber-950">Suivre la chatterie</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="mt-12 grid gap-6 lg:grid-cols-[1fr_1fr]">
        <article class="section-card p-8">
            <p class="eyebrow">Avant de nous ecrire</p>
            <h2 class="section-title mt-4">Les informations utiles a preparer</h2>
            <div class="mt-6 grid gap-4">
                <div class="detail-pill">
                    <p class="text-base font-semibold text-amber-950">Votre mode de vie et le temps de presence au foyer.</p>
                </div>
                <div class="detail-pill">
                    <p class="text-base font-semibold text-amber-950">La composition du foyer : enfants, autres animaux, rythme quotidien.</p>
                </div>
                <div class="detail-pill">
                    <p class="text-base font-semibold text-amber-950">Vos attentes : age, sexe, disponibilite immediate ou future.</p>
                </div>
            </div>
        </article>

        <article class="luminous-panel p-8">
            <p class="text-sm uppercase tracking-[0.24em] text-white/65">Processus</p>
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
@endsection
