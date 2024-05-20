<?php

namespace audunru\DynamicCors\Tests;

use Illuminate\Http\Middleware\HandleCors;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->withoutMiddleware([HandleCors::class])
            ->withMiddleware([TestHandleCors::class]);
    }

    protected function defineRoutes($router)
    {
        $router->any('/api/test', fn () => [])->middleware([TestHandleCors::class]);
    }
}
