<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_hello_world(): void
    {
        $response = $this->get('api/hello-world');
        $response->assertJson(["msg" => "Hello World"]);
    }
}
