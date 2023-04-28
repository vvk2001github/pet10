<?php

namespace Tests\Feature;

use Tests\TestCase;

class RootPageTest extends TestCase
{
    public function test_the_home_page_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
