<?php

namespace audunru\DynamicCors\Tests\Feature;

use audunru\DynamicCors\Tests\TestCase;

class HandleCorsTest extends TestCase
{
    public function testCanCustomizePreflightHeaders()
    {
        $response = $this
            ->withHeaders([
                'Origin'                        => 'https://www.example.com',
                'Access-Control-Request-Method' => 'GET',
            ])->options('/api/test');

        $response->assertNoContent()
            ->assertHeader('Access-Control-Allow-Methods', 'GET')
            ->assertHeader('Access-Control-Allow-Origin', 'https://www.example.com')
            ->assertHeader('Access-Control-Allow-Headers', 'x-allowed-header')
            ->assertHeader('Access-Control-Max-Age', '123')
            ->assertHeader('Access-Control-Allow-Credentials', 'true');
    }

    public function testCanCustomizeAllowedOriginUsingAPattern()
    {
        $response = $this
            ->withHeaders([
                'Origin' => 'https://www.examples.com',
            ])->get('/api/test');

        $response->assertOk()
            ->assertHeader('Access-Control-Allow-Origin', 'https://www.examples.com');
    }

    public function testCanCustomizeExposedHeaders()
    {
        $response = $this
            ->withHeaders([
                'Origin' => 'https://www.examples.com',
            ])->get('/api/test');

        $response->assertOk()
            ->assertHeader('Access-Control-Expose-Headers', 'X-Exposed-Header');
    }
}
