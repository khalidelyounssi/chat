<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_update_and_delete_a_category_with_image(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());

        $storeResponse = $this->post(route('admin.categories.store'), [
            'name' => 'Chatons',
            'description' => 'Categorie des chatons',
            'is_active' => '1',
            'image' => UploadedFile::fake()->image('category.jpg'),
        ]);

        $storeResponse->assertRedirect(route('admin.categories.index'));

        $category = Category::query()->firstOrFail();

        $this->assertSame('chatons', $category->slug);
        Storage::disk('public')->assertExists($category->image);

        $updateResponse = $this->put(route('admin.categories.update', $category), [
            'name' => 'Adultes',
            'description' => 'Categorie adultes',
        ]);

        $updateResponse->assertRedirect(route('admin.categories.index'));

        $category->refresh();
        $this->assertSame('adultes', $category->slug);
        $this->assertFalse($category->is_active);

        $deleteResponse = $this->delete(route('admin.categories.destroy', $category));

        $deleteResponse->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
