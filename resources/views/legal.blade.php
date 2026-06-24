@extends('layouts.public')

@section('title', 'Mentions legales - Chatterie des Soleils d\'Orient')
@section('meta_description', 'Consultez les informations legales, de contact et de confidentialite associees au site de la chatterie.')

@section('meta_robots', 'index,follow')

@section('content')
    @php
        $site = config('chatterie.site');
        $legal = config('chatterie.legal');
        $phone = (string) data_get($site, 'phone', '');
        $phoneLink = preg_replace('/[^+\d]/', '', $phone);
        $email = (string) data_get($site, 'email', '');
        $ownerName = (string) data_get($site, 'owner_name', '');
        $hostName = (string) data_get($legal, 'host_name', '');
        $hostUrl = (string) data_get($legal, 'host_url', '');
    @endphp

    <section class="hero-glow glass-panel overflow-hidden px-6 py-10 sm:px-8 lg:px-12">
        <div class="max-w-3xl">
            <p class="eyebrow">Mentions legales</p>
            <h1 class="page-title mt-4">Informations de publication</h1>
            <p class="body-copy mt-6">
                Cette page rassemble les informations utiles relatives a l'editeur du site, a l'hebergement,
                a la propriete intellectuelle et a l'usage des donnees personnelles.
            </p>
        </div>
    </section>

    <section class="mt-12 grid gap-6 lg:grid-cols-2">
        <article class="section-card p-8">
            <p class="eyebrow">Editeur du site</p>
            <div class="mt-5 space-y-4">
                <div class="detail-pill">
                    <p class="eyebrow">Nom</p>
                    <p class="mt-2 text-lg font-semibold text-amber-950">{{ data_get($site, 'legal_name') }}</p>
                </div>
                @if ($ownerName !== '')
                    <div class="detail-pill">
                        <p class="eyebrow">Responsable de la publication</p>
                        <p class="mt-2 text-lg font-semibold text-amber-950">{{ $ownerName }}</p>
                    </div>
                @endif
                <div class="detail-pill">
                    <p class="eyebrow">Activite</p>
                    <p class="mt-2 text-lg font-semibold text-amber-950">{{ data_get($site, 'legal_status') }}</p>
                </div>
                <div class="detail-pill">
                    <p class="eyebrow">Adresse</p>
                    <p class="mt-2 text-lg font-semibold text-amber-950">{{ data_get($site, 'address') }}</p>
                </div>
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
                @if (data_get($legal, 'siret'))
                    <div class="detail-pill">
                        <p class="eyebrow">SIRET</p>
                        <p class="mt-2 text-lg font-semibold text-amber-950">{{ data_get($legal, 'siret') }}</p>
                    </div>
                @endif
                @if (data_get($legal, 'vat'))
                    <div class="detail-pill">
                        <p class="eyebrow">TVA</p>
                        <p class="mt-2 text-lg font-semibold text-amber-950">{{ data_get($legal, 'vat') }}</p>
                    </div>
                @endif
            </div>
        </article>

        <article class="section-card p-8">
            <p class="eyebrow">Hebergement et confidentialite</p>
            <div class="mt-5 space-y-4">
                <div class="detail-pill">
                    <p class="eyebrow">Hebergeur</p>
                    @if ($hostName !== '')
                        <p class="mt-2 text-lg font-semibold text-amber-950">{{ $hostName }}</p>
                        @if ($hostUrl !== '')
                            <a href="{{ $hostUrl }}" target="_blank" rel="noopener noreferrer" class="mt-2 inline-block text-sm text-amber-800 hover:text-amber-950">{{ $hostUrl }}</a>
                        @endif
                    @else
                        <p class="mt-2 text-lg font-semibold text-amber-950">Renseigne au moment de la mise en production definitive.</p>
                    @endif
                </div>
                <div class="detail-pill">
                    <p class="eyebrow">Propriete intellectuelle</p>
                    <p class="mt-2 subtle-text">
                        Les textes, images et elements graphiques du site restent reserves a l'usage de la chatterie,
                        sauf mention contraire ou accord prealable.
                    </p>
                </div>
                <div class="detail-pill">
                    <p class="eyebrow">Donnees personnelles</p>
                    <p class="mt-2 subtle-text">
                        Les informations transmises via e-mail, telephone ou messagerie servent uniquement a traiter
                        vos demandes de contact et d'adoption. Vous pouvez demander leur suppression a tout moment.
                    </p>
                </div>
                <div class="detail-pill">
                    <p class="eyebrow">Cookies</p>
                    <p class="mt-2 subtle-text">
                        Le site limite son usage de cookies au strict necessaire au fonctionnement technique,
                        sauf ajout futur d'outils de mesure ou de prise de rendez-vous.
                    </p>
                </div>
            </div>
        </article>
    </section>
@endsection
