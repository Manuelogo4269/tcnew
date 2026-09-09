<?php

namespace Tests\Feature;

use App\Models\Story;
use Tests\TestCase;

class EnterpriseStoriesTest extends TestCase
{
    public function test_central_portal_displays_stories_tray_and_create_button(): void
    {
        $response = $this->get('http://localhost/');
        $response->assertStatus(200);

        // Verify stories tray and create button
        $response->assertSee('storiesTraySection');
        $response->assertSee('+ Publicar');
        $response->assertSee('createStoryModal');
        $response->assertSee('Publicar Historia de Empresa');
        $response->assertSee('storyViewerModal');
    }

    public function test_api_creates_enterprise_story_with_validation(): void
    {
        $storyData = [
            'tenant_id' => 'acropolis',
            'store_name' => 'Café Acrópolis',
            'store_logo' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb',
            'media_url' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd',
            'caption' => 'Promoción especial de café y postre zacatecano',
            'cta_text' => 'Aprovechar Oferta',
            'whatsapp_number' => '4929221155',
            'duration_seconds' => 6,
        ];

        $response = $this->postJson('http://localhost/api/stories', $storyData);
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('story.store_name', 'Café Acrópolis')
            ->assertJsonPath('story.caption', 'Promoción especial de café y postre zacatecano');

        $this->assertDatabaseHas('stories', [
            'tenant_id' => 'acropolis',
            'store_name' => 'Café Acrópolis',
            'caption' => 'Promoción especial de café y postre zacatecano',
        ]);
    }

    public function test_api_increments_story_view_count(): void
    {
        $story = Story::create([
            'tenant_id' => 'donajulia',
            'store_name' => 'Gorditas Doña Julia',
            'media_url' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47',
            'caption' => 'Gorditas de asado en el Centro',
            'views_count' => 10,
            'is_active' => true,
        ]);

        $response = $this->postJson("http://localhost/api/stories/{$story->id}/view");
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('views_count', 11);

        $this->assertEquals(11, $story->fresh()->views_count);
    }

    public function test_api_lists_active_stories(): void
    {
        $response = $this->getJson('http://localhost/api/stories');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'stories' => [
                    '*' => ['id', 'store_name', 'media_url'],
                ],
            ]);
    }
}