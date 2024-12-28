<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function authTest(): void
    {
        $response = $this->post('/api/v1/auth/login',
            ['mobile' => '09372791489']
        );

        // Assert
        $response->assertStatus(200);

        $response->dd();
    }
}
