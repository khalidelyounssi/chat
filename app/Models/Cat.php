<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'gender',
        'breed',
        'color',
        'weight',
        'status',
        'description',
        'image',
        'gallery',
        'birth_date',
        'slug',
        'category_id',
    ];

    protected $casts = [
        'gallery' => 'array',
        'birth_date' => 'date',
        'weight' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return config('chatterie.statuses.' . $this->status, ucfirst((string) $this->status));
    }

    public function getGenderLabelAttribute(): string
    {
        return config('chatterie.genders.' . $this->gender, ucfirst((string) $this->gender));
    }

    public function getDisplayAgeAttribute(): ?string
    {
        if ($this->birth_date instanceof Carbon) {
            $months = $this->birth_date->diffInMonths(now());

            if ($months < 12) {
                return $months . ' ' . ($months > 1 ? 'mois' : 'mois');
            }

            $years = intdiv($months, 12);
            $remainingMonths = $months % 12;

            if ($remainingMonths === 0) {
                return $years . ' ' . ($years > 1 ? 'ans' : 'an');
            }

            return sprintf(
                '%d %s %d mois',
                $years,
                $years > 1 ? 'ans' : 'an',
                $remainingMonths
            );
        }

        if ($this->age !== null) {
            return $this->age . ' ' . ($this->age > 1 ? 'ans' : 'an');
        }

        return null;
    }
}
