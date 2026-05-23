<?php

namespace Tests\Feature;

use App\Models\Cat;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicCatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_cats_index_uses_pagination_of_nine_items(): void
    {
        Cat::factory()->count(10)->create();

        $response = $this->get(route('cats.index'));

        $response->assertOk();
        $response->assertViewHas('cats', fn ($cats) => $cats->perPage() === 9 && $cats->total() === 10);
    }

    public function test_cats_can_be_filtered_by_active_category_slug(): void
    {
        $firstCategory = Category::factory()->create(['name' => 'Adultes', 'slug' => 'adultes', 'is_active' => true]);
        $secondCategory = Category::factory()->create(['name' => 'Chatons', 'slug' => 'chatons', 'is_active' => true]);

        Cat::factory()->create(['name' => 'Nala', 'category_id' => $firstCategory->id]);
        Cat::factory()->create(['name' => 'Simba', 'category_id' => $secondCategory->id]);

        $response = $this->get(route('cats.index', ['categorie' => 'adultes']));

        $response->assertOk();
        $response->assertSee('Nala');
        $response->assertDontSee('Simba');
    }

    public function test_cat_show_page_works_with_slug_binding(): void
    {
        $cat = Cat::factory()->create([
            'name' => 'Nour',
            'slug' => 'nour',
        ]);

        $response = $this->get(route('cats.show', ['cat' => $cat->slug]));

        $response->assertOk();
        $response->assertSee('Nour');
    }
}
