@extends('layouts.admin')

@section('title', 'Chats - Admin')
@section('page-title', 'Gestion des chats')

@section('content')
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="subtle-text max-w-2xl">Une vue plus lisible sur mobile, avec cartes compactes sur petit ecran et tableau detaille sur desktop.</p>
        <a href="{{ route('admin.cats.create') }}" class="btn-primary w-full sm:w-auto">Ajouter un chat</a>
    </div>

    <div class="space-y-4 md:hidden">
        @forelse ($cats as $cat)
            <article class="admin-mobile-card">
                <div class="flex items-start gap-4">
                    @if ($cat->image)
                        <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" class="h-[4.5rem] w-[4.5rem] rounded-2xl object-cover">
                    @else
                        <div class="flex h-[4.5rem] w-[4.5rem] items-center justify-center rounded-2xl bg-amber-50 text-xs text-amber-700">N/A</div>
                    @endif

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <h2 class="text-2xl font-semibold text-amber-950">{{ $cat->name }}</h2>
                                <p class="mt-1 text-sm text-stone-600">{{ $cat->category?->name ?? 'Aucune categorie' }}</p>
                            </div>
                            <x-status-badge :status="$cat->status" />
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ route('admin.cats.show', $cat) }}" class="rounded-full border border-stone-200 px-3 py-1.5 text-xs font-semibold text-stone-600 hover:bg-stone-50">Voir</a>
                            <a href="{{ route('admin.cats.edit', $cat) }}" class="rounded-full border border-amber-200 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-50">Modifier</a>
                            <form action="{{ route('admin.cats.destroy', $cat) }}" method="POST" onsubmit="return confirm('Supprimer ce chat ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="admin-panel px-5 py-8 text-center text-stone-500">Aucun chat enregistre.</div>
        @endforelse
    </div>

    <div class="admin-panel hidden overflow-hidden md:block">
        <div class="overflow-x-auto">
            <table class="admin-table min-w-full text-left text-sm">
                <thead>
                    <tr>
                        <th class="px-5 py-3">Image</th>
                        <th class="px-5 py-3">Nom</th>
                        <th class="px-5 py-3">Categorie</th>
                        <th class="px-5 py-3">Statut</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cats as $cat)
                        <tr>
                            <td class="px-5 py-3">
                                @if ($cat->image)
                                    <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" class="h-12 w-12 rounded-xl object-cover">
                                @else
                                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-xs text-amber-700">N/A</div>
                                @endif
                            </td>
                            <td class="px-5 py-3 font-semibold text-stone-800">{{ $cat->name }}</td>
                            <td class="px-5 py-3 text-stone-600">{{ $cat->category?->name ?? 'Aucune' }}</td>
                            <td class="px-5 py-3"><x-status-badge :status="$cat->status" /></td>
                            <td class="px-5 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.cats.show', $cat) }}" class="rounded-full border border-stone-200 px-3 py-1.5 text-xs font-semibold text-stone-600 hover:bg-stone-50">Voir</a>
                                    <a href="{{ route('admin.cats.edit', $cat) }}" class="rounded-full border border-amber-200 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-50">Modifier</a>
                                    <form action="{{ route('admin.cats.destroy', $cat) }}" method="POST" onsubmit="return confirm('Supprimer ce chat ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-full border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-stone-500">Aucun chat enregistre.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $cats->links() }}
    </div>
@endsection
