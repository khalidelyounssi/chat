@extends('layouts.admin')

@section('title', 'Details chat - Admin')
@section('page-title', 'Details chat')

@section('content')
    <section class="card-soft overflow-hidden">
        <div class="grid gap-0 lg:grid-cols-2">
            <div class="bg-amber-100">
                @if ($cat->image)
                    <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" class="h-full w-full object-cover">
                @else
                    <div class="flex min-h-[320px] items-center justify-center text-amber-700">Image indisponible</div>
                @endif
            </div>
            <div class="space-y-5 p-6 sm:p-8">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-3xl font-semibold text-stone-900">{{ $cat->name }}</h2>
                    <x-status-badge :status="$cat->status" />
                </div>

                <dl class="grid gap-3 text-sm text-stone-700 sm:grid-cols-2">
                    <div>
                        <dt class="font-semibold text-stone-500">Slug</dt>
                        <dd>{{ $cat->slug }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-stone-500">Categorie</dt>
                        <dd>{{ $cat->category?->name ?? 'Aucune' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-stone-500">Genre</dt>
                        <dd>{{ $cat->gender_label }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-stone-500">Race</dt>
                        <dd>{{ $cat->breed }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-stone-500">Age</dt>
                        <dd>{{ $cat->display_age ?? 'Non renseigne' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-stone-500">Poids</dt>
                        <dd>{{ $cat->weight ? $cat->weight . ' kg' : 'Non renseigne' }}</dd>
                    </div>
                </dl>

                @if ($cat->description)
                    <div>
                        <p class="font-semibold text-stone-500">Description</p>
                        <p class="mt-2 text-sm leading-relaxed text-stone-700">{{ $cat->description }}</p>
                    </div>
                @endif

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.cats.edit', $cat) }}" class="btn-primary">Modifier</a>
                    <a href="{{ route('admin.cats.index') }}" class="btn-outline">Retour</a>
                </div>
            </div>
        </div>
    </section>

    @if (is_array($cat->gallery) && count($cat->gallery) > 0)
        <section class="mt-8">
            <h3 class="mb-3 text-2xl font-semibold text-stone-900">Galerie</h3>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($cat->gallery as $image)
                    <img src="{{ asset('storage/' . $image) }}" alt="Galerie {{ $cat->name }}" class="h-40 w-full rounded-xl object-cover">
                @endforeach
            </div>
        </section>
    @endif
@endsection
