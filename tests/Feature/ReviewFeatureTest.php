<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_submit_a_review_that_stays_hidden_until_approved(): void
    {
        $response = $this->post(route('reviews.store'), [
            'name' => 'Sophie',
            'rating' => 5,
            'comment' => 'Une tres belle experience avec la chatterie.',
        ]);

        $response->assertRedirect(route('about').'#avis');
        $this->assertDatabaseHas('reviews', [
            'name' => 'Sophie',
            'rating' => 5,
            'is_approved' => false,
        ]);
        $this->get(route('about'))->assertDontSee('Une tres belle experience');
    }

    public function test_admin_can_publish_and_hide_a_review(): void
    {
        $admin = User::factory()->create(['email' => 'admin@soleils-orient.test']);
        $review = Review::create([
            'name' => 'Nadia',
            'rating' => 5,
            'comment' => 'Accueil chaleureux et accompagnement serieux.',
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.reviews.update', $review), ['is_approved' => true])
            ->assertRedirect();

        $review->refresh();
        $this->assertTrue($review->is_approved);
        $this->assertNotNull($review->approved_at);
        $this->get(route('about'))->assertSee('Accueil chaleureux');

        $this->patch(route('admin.reviews.update', $review), ['is_approved' => false]);
        $this->assertFalse($review->fresh()->is_approved);
    }

    public function test_review_submission_is_validated(): void
    {
        $this->post(route('reviews.store'), [
            'name' => '',
            'rating' => 8,
            'comment' => 'Court',
        ])->assertSessionHasErrors(['name', 'rating', 'comment']);
    }
}
