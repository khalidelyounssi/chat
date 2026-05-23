@extends('layouts.admin')

@section('title', 'Dashboard - Admin Chatterie')
@section('page-title', 'Tableau de bord')

@section('content')
    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <div class="admin-stat-card">
            <p class="eyebrow">Chats</p>
            <p class="metric-value">{{ $stats['cats_total'] }}</p>
            <p class="subtle-text mt-3">Nombre total de profils enregistres.</p>
        </div>
        <div class="admin-stat-card">
            <p class="eyebrow">Disponibles</p>
            <p class="mt-4 text-5xl font-display text-emerald-700">{{ $stats['cats_available'] }}</p>
            <p class="subtle-text mt-3">Chats actuellement proposes.</p>
        </div>
        <div class="admin-stat-card">
            <p class="eyebrow">Reserves</p>
            <p class="mt-4 text-5xl font-display text-amber-700">{{ $stats['cats_reserved'] }}</p>
            <p class="subtle-text mt-3">Profils engages avec une famille.</p>
        </div>
        <div class="admin-stat-card">
            <p class="eyebrow">Vendus</p>
            <p class="mt-4 text-5xl font-display text-stone-700">{{ $stats['cats_sold'] }}</p>
            <p class="subtle-text mt-3">Historique des adoptions finalisees.</p>
        </div>
        <div class="admin-stat-card">
            <p class="eyebrow">Categories</p>
            <p class="metric-value">{{ $stats['categories_total'] }}</p>
            <p class="subtle-text mt-3">Nombre de categories configurees.</p>
        </div>
        <div class="luminous-panel p-6">
            <p class="text-sm uppercase tracking-[0.24em] text-white/65">Actives</p>
            <p class="mt-3 font-display text-6xl text-white">{{ $stats['categories_active'] }}</p>
            <p class="mt-3 text-sm leading-7 text-white/80">Categories visibles sur le site public.</p>
        </div>
    </section>

    <section class="admin-panel mt-8 overflow-hidden">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-amber-100 px-5 py-4 sm:px-6">
            <div>
                <p class="eyebrow">Suivi recent</p>
                <h2 class="mt-2 text-3xl font-semibold text-amber-950">Derniers chats</h2>
            </div>
            <a href="{{ route('admin.cats.index') }}" class="btn-secondary">Gerer les chats</a>
        </div>

        <div class="overflow-x-auto">
            <table class="admin-table min-w-full text-left text-sm">
                <thead>
                    <tr>
                        <th class="px-5 py-4 sm:px-6">Nom</th>
                        <th class="px-5 py-4 sm:px-6">Categorie</th>
                        <th class="px-5 py-4 sm:px-6">Statut</th>
                        <th class="px-5 py-4 sm:px-6">Ajoute le</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestCats as $cat)
                        <tr>
                            <td class="px-5 py-4 font-semibold text-stone-800 sm:px-6">{{ $cat->name }}</td>
                            <td class="px-5 py-4 text-stone-600 sm:px-6">{{ $cat->category?->name ?? 'Aucune' }}</td>
                            <td class="px-5 py-4 sm:px-6"><x-status-badge :status="$cat->status" /></td>
                            <td class="px-5 py-4 text-stone-500 sm:px-6">{{ $cat->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-stone-500 sm:px-6">Aucun chat enregistre.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
