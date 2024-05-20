<?php

namespace audunru\DynamicCors\Tests;

use audunru\DynamicCors\Middleware\HandleCors;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class TestHandleCors extends HandleCors
{
    protected ?array $allowedMethods = ['GET'];
    protected ?array $allowedOrigins = ['https://www.example.com'];
    protected ?array $allowedOriginsPatterns = ['/examples?\.com/'];
    protected ?array $allowedHeaders = ['X-Allowed-Header'];
    protected ?array $exposedHeaders = ['X-Exposed-Header'];
    protected ?int $maxAge = 123;
    protected ?bool $supportsCredentials = true;
}
