<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cat;
use App\Models\Category;
use App\Models\Review;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'cats_total' => Cat::query()->count(),
            'cats_available' => Cat::query()->where('status', 'available')->count(),
            'cats_reserved' => Cat::query()->where('status', 'reserved')->count(),
            'cats_sold' => Cat::query()->where('status', 'sold')->count(),
            'categories_total' => Category::query()->count(),
            'categories_active' => Category::query()->where('is_active', true)->count(),
            'reviews_pending' => Review::query()->where('is_approved', false)->count(),
        ];

        $latestCats = Cat::query()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestCats'));
    }
}
