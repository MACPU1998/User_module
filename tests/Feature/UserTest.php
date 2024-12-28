<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function _blogs(): void
    {
        //$user = User::find(1);
        $response = $this->get('/api/v1/blogs/index');
        $response->dd();
        // Assert
        $response->assertStatus(200);
    }

    public function _post(): void
    {
        //$user = User::find(1);
        $response = $this->get('/api/v1/blogs/post/1');
        $response->dd();
        // Assert
        $response->assertStatus(200);
    }

    public function _app_version(): void
    {
        //$user = User::find(1);
        $response = $this->get('/api/v1/app/version/last');
        $response->dd();
        // Assert
        $response->assertStatus(200);
    }
}
