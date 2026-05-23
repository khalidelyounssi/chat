@extends('layouts.admin')

@section('title', 'Categories - Admin')
@section('page-title', 'Categories')

@section('content')
    <div class="mb-5">
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">Ajouter une categorie</a>
    </div>

    <div class="admin-panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table min-w-full text-left text-sm">
                <thead>
                    <tr>
                        <th class="px-5 py-3">Image</th>
                        <th class="px-5 py-3">Nom</th>
                        <th class="px-5 py-3">Slug</th>
                        <th class="px-5 py-3">Statut</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-5 py-3">
                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="h-12 w-12 rounded-lg object-cover">
                                @else
                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-amber-50 text-xs text-amber-700">N/A</div>
                                @endif
                            </td>
                            <td class="px-5 py-3 font-semibold text-stone-800">{{ $category->name }}</td>
                            <td class="px-5 py-3 text-stone-500">{{ $category->slug }}</td>
                            <td class="px-5 py-3">
                                @if ($category->is_active)
                                    <span class="rounded-full border border-emerald-200 bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">Active</span>
                                @else
                                    <span class="rounded-full border border-stone-200 bg-stone-100 px-2.5 py-1 text-xs font-semibold text-stone-600">Inactive</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="rounded-full border border-stone-200 px-3 py-1.5 text-xs font-semibold text-stone-600 hover:bg-stone-50">Voir</a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="rounded-full border border-amber-200 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-50">Modifier</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Supprimer cette categorie ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-full border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-stone-500">Aucune categorie enregistree.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
@endsection
