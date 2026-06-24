<?php

namespace Tests\Feature;

use App\Models\Cat;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCatCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_update_and_delete_a_cat_with_gallery(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create([
            'email' => 'admin@soleils-orient.test',
        ]));

        $category = Category::factory()->create();

        $storeResponse = $this->post(route('admin.cats.store'), [
            'name' => 'Nova',
            'gender' => 'female',
            'breed' => 'Abyssin',
            'status' => 'available',
            'category_id' => $category->id,
            'image' => UploadedFile::fake()->image('nova.jpg'),
            'gallery' => [
                UploadedFile::fake()->image('g1.jpg'),
                UploadedFile::fake()->image('g2.jpg'),
            ],
        ]);

        $storeResponse->assertRedirect(route('admin.cats.index'));

        $cat = Cat::query()->firstOrFail();

        $this->assertSame('nova', $cat->slug);
        Storage::disk('public')->assertExists($cat->image);

        $gallery = $cat->gallery ?? [];
        $this->assertCount(2, $gallery);
        foreach ($gallery as $path) {
            Storage::disk('public')->assertExists($path);
        }

        $updateResponse = $this->put(route('admin.cats.update', $cat), [
            'name' => 'Nova Prime',
            'gender' => 'female',
            'breed' => 'Abyssin',
            'status' => 'reserved',
            'category_id' => $category->id,
            'remove_image' => '1',
            'remove_gallery' => '1',
        ]);

        $updateResponse->assertRedirect(route('admin.cats.index'));

        $cat->refresh();
        $this->assertSame('nova-prime', $cat->slug);
        $this->assertNull($cat->image);
        $this->assertNull($cat->gallery);

        $deleteResponse = $this->delete(route('admin.cats.destroy', $cat));

        $deleteResponse->assertRedirect(route('admin.cats.index'));
        $this->assertDatabaseMissing('cats', ['id' => $cat->id]);
    }
}
