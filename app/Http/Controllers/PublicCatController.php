<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\Category;
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

        $query = Cat::query()
            ->with('category')
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
        $cat->load('category');

        $whatsappMessage = sprintf('Bonjour je suis interesse par %s', $cat->name);

        return view('cats.show', [
            'cat' => $cat,
            'whatsappMessage' => $whatsappMessage,
        ]);
    }
}
