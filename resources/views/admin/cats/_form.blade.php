@php
    $cat = $cat ?? null;
@endphp

<div class="admin-form-shell">
    <section class="admin-form-section">
        <div class="mb-5">
            <p class="eyebrow">Identité</p>
            <h2 class="mt-2 text-3xl font-semibold text-amber-950">Informations principales</h2>
            <p class="subtle-text mt-2">Les données essentielles du profil public du chat.</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label for="name" class="label-base">Nom</label>
                <input id="name" type="text" name="name" class="input-base" value="{{ old('name', $cat?->name) }}" required>
            </div>

            <div>
                <label for="category_id" class="label-base">Catégorie</label>
                <select id="category_id" name="category_id" class="input-base">
                    <option value="">Aucune</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) old('category_id', $cat?->category_id) === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="gender" class="label-base">Genre</label>
                <select id="gender" name="gender" class="input-base" required>
                    <option value="male" @selected(old('gender', $cat?->gender) === 'male')>Mâle</option>
                    <option value="female" @selected(old('gender', $cat?->gender) === 'female')>Femelle</option>
                </select>
            </div>

            <div>
                <label for="status" class="label-base">Statut</label>
                <select id="status" name="status" class="input-base" required>
                    <option value="available" @selected(old('status', $cat?->status ?? 'available') === 'available')>Disponible</option>
                    <option value="reserved" @selected(old('status', $cat?->status) === 'reserved')>Réservé</option>
                    <option value="sold" @selected(old('status', $cat?->status) === 'sold')>Vendu</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <input type="hidden" name="is_breeder" value="0">
                <label class="inline-flex items-start gap-3 rounded-2xl border border-amber-200 bg-amber-50/70 p-4">
                    <input type="checkbox" name="is_breeder" value="1" class="mt-1 h-4 w-4 rounded border-stone-300 text-amber-700 focus:ring-amber-500" @checked((bool) old('is_breeder', $cat?->is_breeder ?? false))>
                    <span>
                        <span class="block font-semibold text-amber-950">Chat de la chatterie</span>
                        <span class="mt-1 block text-sm text-stone-600">Cochez cette case pour présenter ce parent reproducteur sans l'afficher parmi les chats à adopter.</span>
                    </span>
                </label>
            </div>
        </div>
    </section>

    <section class="admin-form-section">
        <div class="mb-5">
            <p class="eyebrow">Caractéristiques</p>
            <h2 class="mt-2 text-3xl font-semibold text-amber-950">Details du chat</h2>
            <p class="subtle-text mt-2">Âge, robe, race et informations complémentaires.</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label for="age" class="label-base">Âge (années)</label>
                <input id="age" type="number" min="0" name="age" class="input-base" value="{{ old('age', $cat?->age) }}">
            </div>

            <div>
                <label for="birth_date" class="label-base">Date de naissance</label>
                <input id="birth_date" type="date" name="birth_date" class="input-base" value="{{ old('birth_date', $cat?->birth_date?->format('Y-m-d')) }}">
            </div>

            <div>
                <label for="breed" class="label-base">Race</label>
                <input id="breed" type="text" name="breed" class="input-base" value="{{ old('breed', $cat?->breed ?? 'Abyssin') }}" required>
            </div>

            <div>
                <label for="color" class="label-base">Couleur</label>
                <input id="color" type="text" name="color" class="input-base" value="{{ old('color', $cat?->color) }}">
            </div>

            <div>
                <label for="weight" class="label-base">Poids (kg)</label>
                <input id="weight" type="number" step="0.01" min="0" name="weight" class="input-base" value="{{ old('weight', $cat?->weight) }}">
            </div>

            <div class="md:col-span-2">
                <label for="description" class="label-base">Description</label>
                <textarea id="description" name="description" rows="5" class="input-base">{{ old('description', $cat?->description) }}</textarea>
            </div>
        </div>
    </section>

    <section class="admin-form-section">
        <div class="mb-5">
            <p class="eyebrow">Médias</p>
            <h2 class="mt-2 text-3xl font-semibold text-amber-950">Images et galerie</h2>
            <p class="subtle-text mt-2">Ajoutez une image principale et une galerie pour enrichir la fiche du chat.</p>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="space-y-4">
                <div>
                    <label for="cat_image" class="label-base">Image principale</label>
                    <input id="cat_image" type="file" name="image" accept="image/*" class="input-base px-3 py-2">
                </div>

                @if ($cat?->image)
                    <label class="inline-flex cursor-pointer items-center gap-2 text-sm text-stone-600">
                        <input type="checkbox" name="remove_image" value="1" class="h-4 w-4 rounded border-stone-300 text-red-600 focus:ring-red-500">
                        Supprimer l'image actuelle
                    </label>
                @endif

                <div>
                    <p class="label-base">Aperçu de l'image principale</p>
                    <div id="cat-image-preview" class="admin-upload-box">
                        @if ($cat?->image)
                            <img src="{{ asset('storage/' . $cat->image) }}" alt="Aperçu du chat" class="h-full w-full object-cover">
                        @else
                            Image non définie
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="cat_gallery" class="label-base">Galerie (plusieurs images)</label>
                    <input id="cat_gallery" type="file" name="gallery[]" accept="image/*" multiple class="input-base px-3 py-2">
                </div>

                @if ($cat?->gallery && is_array($cat->gallery) && count($cat->gallery) > 0)
                    <label class="inline-flex cursor-pointer items-center gap-2 text-sm text-stone-600">
                        <input type="checkbox" name="remove_gallery" value="1" class="h-4 w-4 rounded border-stone-300 text-red-600 focus:ring-red-500">
                        Supprimer toute la galerie actuelle
                    </label>

                    <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-4">
                        @foreach ($cat->gallery as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="Galerie" class="h-24 w-full rounded-xl object-cover">
                        @endforeach
                    </div>
                @endif

                <div id="cat-gallery-preview" class="grid gap-3 sm:grid-cols-3 lg:grid-cols-4"></div>
            </div>
        </div>
    </section>
</div>

<div class="mt-8 flex flex-col gap-3 sm:flex-row">
    <button type="submit" class="btn-primary w-full sm:w-auto">Enregistrer</button>
    <a href="{{ route('admin.cats.index') }}" class="btn-outline w-full sm:w-auto">Annuler</a>
</div>
