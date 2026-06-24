@php
    $category = $category ?? null;
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <label for="name" class="label-base">Nom</label>
        <input id="name" type="text" name="name" class="input-base" value="{{ old('name', $category?->name) }}" required>
    </div>

    <div>
        <label for="is_active" class="label-base">Statut</label>
        <label class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-stone-300 bg-white px-4 py-2.5">
            <input type="hidden" name="is_active" value="0">
            <input id="is_active" type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-stone-300 text-amber-600 focus:ring-amber-500" @checked(old('is_active', $category?->is_active ?? true))>
            <span class="text-sm text-stone-700">Categorie active</span>
        </label>
    </div>

    <div class="lg:col-span-2">
        <label for="description" class="label-base">Description</label>
        <textarea id="description" name="description" rows="5" class="input-base">{{ old('description', $category?->description) }}</textarea>
    </div>

    <div>
        <label for="category_image" class="label-base">Image</label>
        <input id="category_image" type="file" name="image" accept="image/*" class="input-base px-3 py-2">
        <p class="mt-1 text-xs text-stone-500">Formats: JPG, PNG, WEBP (max 3MB)</p>
    </div>

    <div>
        <p class="label-base">Apercu</p>
        <div id="category-image-preview" class="flex h-40 w-full items-center justify-center overflow-hidden rounded-xl border border-dashed border-stone-300 bg-stone-50 text-xs text-stone-400">
            @if ($category?->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="Apercu categorie" class="h-full w-full object-cover">
            @else
                Image non definie
            @endif
        </div>
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-3">
    <button type="submit" class="btn-primary">Enregistrer</button>
    <a href="{{ route('admin.categories.index') }}" class="btn-outline">Annuler</a>
</div>
