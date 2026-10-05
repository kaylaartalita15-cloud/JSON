<?php

namespace Tests\Feature;

use Tests\TestCase;

class NewsTest extends TestCase
{
    public function test_news_portal_page_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('NusantaraNews');
    }

    public function test_news_api_endpoint_returns_json()
    {
        $response = $this->get('/api/news?category=technology');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'articles' => [
                '*' => ['title', 'description', 'url'],
            ],
        ]);
    }
}
