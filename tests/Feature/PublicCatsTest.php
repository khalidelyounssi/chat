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
        Cat::factory()->count(9)->create(['status' => 'available']);
        Cat::factory()->create(['status' => 'reserved']);
        Cat::factory()->create(['status' => 'sold']);

        $response = $this->get(route('cats.index'));

        $response->assertOk();
        $response->assertViewHas('cats', fn ($cats) => $cats->perPage() === 9 && $cats->total() === 10);
    }

    public function test_cats_can_be_filtered_by_active_category_slug(): void
    {
        $firstCategory = Category::factory()->create(['name' => 'Adultes', 'slug' => 'adultes', 'is_active' => true]);
        $secondCategory = Category::factory()->create(['name' => 'Chatons', 'slug' => 'chatons', 'is_active' => true]);

        Cat::factory()->create(['name' => 'Nala', 'category_id' => $firstCategory->id, 'status' => 'available']);
        Cat::factory()->create(['name' => 'Simba', 'category_id' => $secondCategory->id, 'status' => 'available']);

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
            'status' => 'available',
        ]);

        $response = $this->get(route('cats.show', ['cat' => $cat->slug]));

        $response->assertOk();
        $response->assertSee('Nour');
    }

    public function test_sold_cats_are_hidden_from_public_pages(): void
    {
        $visibleCat = Cat::factory()->create(['name' => 'Lina', 'slug' => 'lina', 'status' => 'available']);
        $soldCat = Cat::factory()->create(['name' => 'Orion', 'slug' => 'orion', 'status' => 'sold']);

        $indexResponse = $this->get(route('cats.index'));

        $indexResponse->assertOk();
        $indexResponse->assertSee('Lina');
        $indexResponse->assertDontSee('Orion');

        $showResponse = $this->get(route('cats.show', ['cat' => $soldCat->slug]));

        $showResponse->assertNotFound();
        $this->assertSame($visibleCat->slug, 'lina');
    }

    public function test_contact_and_legal_pages_are_available(): void
    {
        $this->get(route('contact'))->assertOk();
        $this->get(route('legal'))->assertOk();
        $this->get(route('guides.adoption'))->assertOk();
        $this->get(route('guides.breed'))->assertOk();
        $this->get(route('guides.local'))->assertOk();
    }

    public function test_sitemap_lists_core_pages_and_visible_cats(): void
    {
        Cat::factory()->create(['name' => 'Naya', 'slug' => 'naya', 'status' => 'available']);
        Cat::factory()->create(['name' => 'Atlas', 'slug' => 'atlas', 'status' => 'sold']);

        $response = $this->get(route('sitemap'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee(route('home'), false);
        $response->assertSee(route('contact'), false);
        $response->assertSee(route('guides.adoption'), false);
        $response->assertSee(route('guides.breed'), false);
        $response->assertSee(route('guides.local'), false);
        $response->assertSee(route('cats.show', ['cat' => 'naya']), false);
        $response->assertDontSee(route('cats.show', ['cat' => 'atlas']), false);
    }

    public function test_robots_file_exposes_restrictions_and_sitemap(): void
    {
        $response = $this->get(route('robots'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $response->assertSee('Disallow: /admin');
        $response->assertSee(route('sitemap'));
    }
}
