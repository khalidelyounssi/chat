<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicCatController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::query()
            ->active()
            ->orderBy('name')
            ->get();

        $selectedCategorySlug = trim((string) $request->query('categorie', ''));
        $selectedCategory = null;
        $invalidCategory = false;
        $publicStatuses = config('chatterie.public_statuses', ['available', 'reserved']);

        $query = Cat::query()
            ->with('category')
            ->whereIn('status', $publicStatuses)
            ->latest();

        if ($selectedCategorySlug !== '') {
            $selectedCategory = $categories->firstWhere('slug', $selectedCategorySlug);

            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            } else {
                $invalidCategory = true;
                $query->whereRaw('1 = 0');
            }
        }

        $cats = $query->paginate(9)->withQueryString();

        return view('cats.index', [
            'cats' => $cats,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'selectedCategorySlug' => $selectedCategorySlug,
            'invalidCategory' => $invalidCategory,
        ]);
    }

    public function show(Cat $cat): View
    {
        abort_unless(
            in_array($cat->status, config('chatterie.public_statuses', ['available', 'reserved']), true),
            404
        );

        $cat->load('category');

        $whatsappMessage = sprintf("Bonjour, je souhaite recevoir plus d'informations sur %s.", $cat->name);

        $relatedCats = Cat::query()
            ->with('category')
            ->whereKeyNot($cat->getKey())
            ->whereIn('status', config('chatterie.public_statuses', ['available', 'reserved']))
            ->when(
                $cat->category_id,
                fn (Builder $query): Builder => $query->where('category_id', $cat->category_id),
                fn (Builder $query): Builder => $query
            )
            ->latest()
            ->take(3)
            ->get();

        return view('cats.show', [
            'cat' => $cat,
            'relatedCats' => $relatedCats,
            'whatsappMessage' => $whatsappMessage,
        ]);
    }
}
