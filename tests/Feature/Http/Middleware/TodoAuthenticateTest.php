<?php

namespace Psli\Todo\Tests\Feature\Http\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Psli\Todo\Tests\TestCase;
use Illuminate\Foundation\Auth\User;

/**
 * @see \Psli\Todo\Http\Middleware\TodoAuthMiddleware
 */
class TodoAuthenticateTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_middleware_authentication_with_no_header()
    {
        $response = $this->json('post', route('api.todos.labels.store'), [
            'label' => 'Backend'
        ]);

        $response->assertStatus(401);
    }
}
