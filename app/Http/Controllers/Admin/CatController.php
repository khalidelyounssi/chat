<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCatRequest;
use App\Http\Requests\Admin\UpdateCatRequest;
use App\Models\Cat;
use App\Models\Category;
use App\Support\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CatController extends Controller
{
    public function index(): View
    {
        $cats = Cat::query()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('admin.cats.index', compact('cats'));
    }

    public function create(): View
    {
        $categories = Category::query()
            ->orderByDesc('is_active')
            ->orderBy('name')
            ->get();

        return view('admin.cats.create', compact('categories'));
    }

    public function store(StoreCatRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = SlugService::unique(Cat::class, $data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cats', 'public');
        }

        if ($request->hasFile('gallery')) {
            $data['gallery'] = $this->storeGallery($request->file('gallery'));
        }

        Cat::create($data);

        return redirect()
            ->route('admin.cats.index')
            ->with('success', 'Chat ajoute avec succès.');
    }

    public function show(Cat $cat): View
    {
        $cat->load('category');

        return view('admin.cats.show', compact('cat'));
    }

    public function edit(Cat $cat): View
    {
        $categories = Category::query()
            ->orderByDesc('is_active')
            ->orderBy('name')
            ->get();

        return view('admin.cats.edit', compact('cat', 'categories'));
    }

    public function update(UpdateCatRequest $request, Cat $cat): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = SlugService::unique(Cat::class, $data['name'], $cat->id);

        if ($request->boolean('remove_image') && $cat->image) {
            Storage::disk('public')->delete($cat->image);
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($cat->image) {
                Storage::disk('public')->delete($cat->image);
            }

            $data['image'] = $request->file('image')->store('cats', 'public');
        }

        if ($request->boolean('remove_gallery') && is_array($cat->gallery)) {
            $this->deleteGallery($cat->gallery);
            $data['gallery'] = null;
        }

        if ($request->hasFile('gallery')) {
            if (is_array($cat->gallery)) {
                $this->deleteGallery($cat->gallery);
            }

            $data['gallery'] = $this->storeGallery($request->file('gallery'));
        }

        unset($data['remove_image'], $data['remove_gallery']);

        $cat->update($data);

        return redirect()
            ->route('admin.cats.index')
            ->with('success', 'Chat mis à jour avec succès.');
    }

    public function destroy(Cat $cat): RedirectResponse
    {
        if ($cat->image) {
            Storage::disk('public')->delete($cat->image);
        }

        if (is_array($cat->gallery)) {
            $this->deleteGallery($cat->gallery);
        }

        $cat->delete();

        return redirect()
            ->route('admin.cats.index')
            ->with('success', 'Chat supprime avec succès.');
    }

    /**
     * @param array<int, UploadedFile> $gallery
     * @return array<int, string>
     */
    private function storeGallery(array $gallery): array
    {
        return collect($gallery)
            ->map(fn (UploadedFile $file): string => $file->store('cats/gallery', 'public'))
            ->values()
            ->all();
    }

    /**
     * @param array<int, string> $gallery
     */
    private function deleteGallery(array $gallery): void
    {
        Storage::disk('public')->delete($gallery);
    }
}
