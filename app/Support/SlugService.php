<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugService
{
    /**
     * @param class-string<Model> $modelClass
     */
    public static function unique(string $modelClass, string $value, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($value);

        if ($baseSlug === '') {
            $baseSlug = 'item-' . Str::lower(Str::random(6));
        }

        $slug = $baseSlug;
        $iteration = 2;

        $model = new $modelClass();
        $keyName = $model->getKeyName();

        while (self::slugExists($modelClass, $slug, $keyName, $ignoreId)) {
            $slug = $baseSlug . '-' . $iteration;
            $iteration++;
        }

        return $slug;
    }

    /**
     * @param class-string<Model> $modelClass
     */
    private static function slugExists(string $modelClass, string $slug, string $keyName, ?int $ignoreId): bool
    {
        $query = $modelClass::query()->where('slug', $slug);

        if ($ignoreId !== null) {
            $query->where($keyName, '!=', $ignoreId);
        }

        return $query->exists();
    }
}
