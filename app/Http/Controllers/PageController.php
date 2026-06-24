<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Response;
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

    public function contact(): View
    {
        return view('contact');
    }

    public function legal(): View
    {
        return view('legal');
    }

    public function sitemap(): Response
    {
        $staticUrls = collect([
            ['loc' => route('home'), 'lastmod' => now()->toDateString(), 'priority' => '1.0'],
            ['loc' => route('cats.index'), 'lastmod' => now()->toDateString(), 'priority' => '0.9'],
            ['loc' => route('about'), 'lastmod' => now()->toDateString(), 'priority' => '0.7'],
            ['loc' => route('contact'), 'lastmod' => now()->toDateString(), 'priority' => '0.8'],
            ['loc' => route('legal'), 'lastmod' => now()->toDateString(), 'priority' => '0.3'],
        ]);

        $catUrls = Cat::query()
            ->whereIn('status', config('chatterie.public_statuses', ['available', 'reserved']))
            ->latest('updated_at')
            ->get()
            ->map(fn (Cat $cat): array => [
                'loc' => route('cats.show', $cat),
                'lastmod' => optional($cat->updated_at)->toDateString() ?? now()->toDateString(),
                'priority' => '0.8',
            ]);

        return response()
            ->view('sitemap', ['urls' => $staticUrls->concat($catUrls)])
            ->header('Content-Type', 'application/xml');
    }
}
