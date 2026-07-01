<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request): RedirectResponse
    {
        Review::create($request->safe()->only(['name', 'rating', 'comment']));

        return redirect(route('about').'#avis')
            ->with('success', 'Merci pour votre avis. Il sera affiche apres validation par la chatterie.');
    }
}
