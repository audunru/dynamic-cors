<?php

namespace audunru\DynamicCors\Tests;

use audunru\DynamicCors\Middleware\HandleCors;

class TestHandleCors extends HandleCors
{
    protected $allowed_methods = ['GET'];
    protected $allowed_origins = ['https://www.example.com'];
    protected $allowed_origins_patterns = ['/examples?\.com/'];
    protected $allowed_headers = ['X-Allowed-Header'];
    protected $exposed_headers = ['X-Exposed-Header'];
    protected $max_age = 123;
    protected $supports_credentials = true;
}
