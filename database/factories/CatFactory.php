<?php

namespace Database\Factories;

use App\Models\Cat;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Cat>
 */
class CatFactory extends Factory
{
    protected $model = Cat::class;

    public function definition(): array
    {
        $name = fake()->unique()->firstName();

        return [
            'name' => $name,
            'age' => fake()->numberBetween(1, 10),
            'gender' => fake()->randomElement(['male', 'female']),
            'breed' => 'Abyssin',
            'color' => fake()->safeColorName(),
            'weight' => fake()->randomFloat(2, 2, 7),
            'status' => fake()->randomElement(['available', 'reserved', 'sold']),
            'description' => fake()->sentence(),
            'image' => null,
            'gallery' => null,
            'birth_date' => fake()->dateTimeBetween('-5 years', '-6 months')->format('Y-m-d'),
            'slug' => Str::slug($name . '-' . fake()->unique()->numerify('###')),
            'category_id' => Category::factory(),
        ];
    }
}
