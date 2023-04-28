<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardPageTest extends TestCase
{
    public function test_the_unauthorized_dashboard_redirects_to_login(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }
}
