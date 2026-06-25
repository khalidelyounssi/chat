<?php

use App\Http\Controllers\Admin\CatController as AdminCatController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PublicCatController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/chats', [PublicCatController::class, 'index'])->name('cats.index');
Route::get('/chats/{cat:slug}', [PublicCatController::class, 'show'])->name('cats.show');
Route::get('/a-propos', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/mentions-legales', [PageController::class, 'legal'])->name('legal');
Route::get('/guides/adopter-chaton-abyssin-saint-ave', [PageController::class, 'adoptionGuide'])->name('guides.adoption');
Route::get('/guides/caractere-chat-abyssin', [PageController::class, 'breedGuide'])->name('guides.breed');
Route::get('/guides/elevage-abyssin-morbihan', [PageController::class, 'localGuide'])->name('guides.local');
Route::get('/robots.txt', [PageController::class, 'robots'])->name('robots');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('cats', AdminCatController::class);
    Route::resource('categories', AdminCategoryController::class);
});
