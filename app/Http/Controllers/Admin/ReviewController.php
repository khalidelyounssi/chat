<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $reviews = Review::query()
            ->orderBy('is_approved')
            ->latest()
            ->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        $data = $request->validate([
            'is_approved' => ['required', 'boolean'],
        ]);

        $approved = (bool) $data['is_approved'];
        $review->update([
            'is_approved' => $approved,
            'approved_at' => $approved ? now() : null,
        ]);

        return back()->with('success', $approved ? 'Avis publie.' : 'Avis masque.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return back()->with('success', 'Avis supprime.');
    }
}
