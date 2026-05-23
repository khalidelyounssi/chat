@extends('layouts.admin')

@section('title', 'Details categorie - Admin')
@section('page-title', 'Details categorie')

@section('content')
    <section class="card-soft p-6 sm:p-8">
        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <p class="subtle-text">Nom</p>
                <p class="mt-1 text-xl font-semibold text-stone-900">{{ $category->name }}</p>
            </div>
            <div>
                <p class="subtle-text">Slug</p>
                <p class="mt-1 text-sm text-stone-700">{{ $category->slug }}</p>
            </div>
            <div>
                <p class="subtle-text">Statut</p>
                <p class="mt-1 text-sm font-semibold {{ $category->is_active ? 'text-emerald-700' : 'text-stone-600' }}">
                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                </p>
            </div>
            <div>
                <p class="subtle-text">Nombre de chats</p>
                <p class="mt-1 text-sm text-stone-700">{{ $category->cats_count }}</p>
            </div>
        </div>

        @if ($category->description)
            <div class="mt-6">
                <p class="subtle-text">Description</p>
                <p class="mt-2 text-sm leading-relaxed text-stone-700">{{ $category->description }}</p>
            </div>
        @endif

        @if ($category->image)
            <div class="mt-6">
                <p class="subtle-text">Image</p>
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="mt-2 h-56 w-full max-w-md rounded-xl object-cover">
            </div>
        @endif

        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn-primary">Modifier</a>
            <a href="{{ route('admin.categories.index') }}" class="btn-outline">Retour</a>
        </div>
    </section>
@endsection
