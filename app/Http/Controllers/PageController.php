<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $featuredCats = Cat::query()
            ->where('status', 'available')
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('featuredCats'));
    }

    public function about(): View
    {
        return view('about');
    }
}
