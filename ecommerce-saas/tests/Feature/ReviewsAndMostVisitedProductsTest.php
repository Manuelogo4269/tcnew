<?php

namespace Tests\Feature;

use App\Models\Review;
use Tests\TestCase;

class ReviewsAndMostVisitedProductsTest extends TestCase
{
    public function test_central_portal_displays_most_visited_products_and_reviews_system(): void
    {
        $response = $this->get('http://localhost/');
        $response->assertStatus(200);

        // Verify Most Visited Products section
        $response->assertSee('Productos Más Visitados de Zacatecas Centro');
        $response->assertSee('most-visited-section');
        $response->assertSee('productosPopulares');

        // Verify Reviews system components
        $response->assertSee('companyReviewsModal');
        $response->assertSee('reviews-section-box');
        $response->assertSee('Opiniones (1 a 5 ★)');

        // Verify Stories and Social Feed have been cleanly removed
        $response->assertDontSee('storiesTraySection');
        $response->assertDontSee('social-feed-stream');
        $response->assertDontSee('storyViewerModal');
    }

    public function test_api_stores_company_review_with_1_to_5_stars(): void
    {
        $reviewData = [
            'reviewable_type' => 'company',
            'reviewable_id' => 'conceptos7',
            'rating' => 5,
            'author_name' => 'Juan Zacatecano',
            'comment' => 'La mejor joyería y ropa en Tacuba y excelente atención personalizada.',
        ];

        $response = $this->postJson('http://localhost/api/reviews', $reviewData);
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('review.author_name', 'Juan Zacatecano')
            ->assertJsonPath('review.rating', 5);

        $this->assertDatabaseHas('reviews', [
            'reviewable_type' => 'company',
            'reviewable_id' => 'conceptos7',
            'author_name' => 'Juan Zacatecano',
            'rating' => 5,
        ]);

        // Validation rejects ratings outside 1-5
        $invalidResponse = $this->postJson('http://localhost/api/reviews', [
            'reviewable_type' => 'company',
            'reviewable_id' => 'conceptos7',
            'rating' => 6,
            'author_name' => 'Test',
            'comment' => 'Inválido',
        ]);
        $invalidResponse->assertStatus(422);
    }

    public function test_api_stores_product_review_with_1_to_5_stars(): void
    {
        $productReviewData = [
            'reviewable_type' => 'product',
            'reviewable_id' => 'collar-choker-eslabones-oro-18k',
            'rating' => 5,
            'author_name' => 'Lucía Alatorre',
            'comment' => 'Diseño elegante y brillo insuperable en Zacatecas.',
        ];

        $response = $this->postJson('http://localhost/api/reviews', $productReviewData);
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('review.author_name', 'Lucía Alatorre')
            ->assertJsonPath('review.rating', 5);

        $this->assertDatabaseHas('reviews', [
            'reviewable_type' => 'product',
            'reviewable_id' => 'collar-choker-eslabones-oro-18k',
            'author_name' => 'Lucía Alatorre',
            'rating' => 5,
        ]);
    }

    public function test_api_lists_reviews_for_company_and_product(): void
    {
        // Company reviews
        $responseCompany = $this->getJson('http://localhost/api/reviews?type=company&id=conceptos7');
        $responseCompany->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'reviews' => [
                    '*' => ['id', 'author_name', 'rating', 'comment'],
                ],
                'average_rating',
            ]);

        // Product reviews
        $responseProduct = $this->getJson('http://localhost/api/reviews?type=product&id=vestido-midi-satinado-espalda-abierta');
        $responseProduct->assertStatus(200)
            ->assertJsonPath('success', true);
    }
}