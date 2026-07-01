@extends('layouts.admin')

@section('title', 'Avis - Admin')
@section('page-title', 'Avis clients')

@section('content')
    <div class="admin-panel overflow-hidden">
        <div class="border-b border-amber-100 px-5 py-5 sm:px-6">
            <p class="eyebrow">Moderation</p>
            <h2 class="mt-2 text-3xl font-semibold text-amber-950">Commentaires recus</h2>
            <p class="mt-2 text-sm text-stone-600">Les nouveaux avis restent invisibles jusqu'a leur publication.</p>
        </div>

        <div class="grid gap-4 p-4 sm:p-6">
            @forelse ($reviews as $review)
                <article class="admin-mobile-card">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <div class="flex flex-wrap items-center gap-3">
                                <h3 class="text-xl font-semibold text-amber-950">{{ $review->name }}</h3>
                                @if ($review->is_approved)
                                    <span class="rounded-full border border-emerald-200 bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">Publie</span>
                                @else
                                    <span class="rounded-full border border-amber-200 bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-800">En attente</span>
                                @endif
                            </div>
                            <div class="review-stars mt-2" aria-label="{{ $review->rating }} etoiles sur 5">
                                @for ($star = 1; $star <= 5; $star++)
                                    <span class="{{ $star > $review->rating ? 'review-star-muted' : '' }}">&#9733;</span>
                                @endfor
                            </div>
                            <p class="mt-3 max-w-3xl text-sm leading-7 text-stone-700">{{ $review->comment }}</p>
                            <p class="mt-3 text-xs text-stone-500">Recu le {{ $review->created_at->format('d/m/Y a H:i') }}</p>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="is_approved" value="{{ $review->is_approved ? 0 : 1 }}">
                                <button type="submit" class="{{ $review->is_approved ? 'btn-secondary' : 'btn-primary' }}">
                                    {{ $review->is_approved ? 'Masquer' : 'Publier' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Supprimer definitivement cet avis ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center rounded-full border border-red-200 bg-white px-5 py-3.5 text-sm font-semibold text-red-700 transition hover:bg-red-50">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="p-8 text-center text-stone-500">Aucun avis recu pour le moment.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        {{ $reviews->links() }}
    </div>
@endsection
