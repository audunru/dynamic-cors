# Dynamic CORS options in Laravel

[![Build Status](https://github.com/audunru/dynamic-cors/actions/workflows/validate.yml/badge.svg)](https://github.com/audunru/dynamic-cors/actions/workflows/validate.yml)
[![Coverage Status](https://coveralls.io/repos/github/audunru/dynamic-cors/badge.svg?branch=master)](https://coveralls.io/github/audunru/dynamic-cors?branch=master)
[![StyleCI](https://github.styleci.io/repos/803402577/shield?branch=master)](https://github.styleci.io/repos/803402577)

Dynamically change Laravel's CORS options. Typically used to configure custom allowed origins per user/account, so that your users can access you applications HTTP API's without CORS errors.

# Installation

## Step 1: Install with Composer

```bash
composer require audunru/dynamic-cors
```

# Configuration

You will have to replace Laravel's default `HandleCors` middleware with a version that extends `audunru\DynamicCors\Middleware\HandleCors`.

1. Ensure that you are [manually managing Laravel's default global middleware](https://laravel.com/docs/11.x/middleware#manually-managing-laravels-default-global-middleware).

2. Remove `\Illuminate\Http\Middleware\HandleCors::class` from the middleware stack.

3. Create a new file `app/Http/Middleware/UserCors.php`.

You can place this wherever you want, and of course name it according to what _you_ want it to do!

This is an example where a user has a list of per-user allowed origins, perhaps controlled by themselves in the application UI.

```php

namespace App\Http\Middleware;

use Closure;
use audunru\DynamicCors\Middleware\HandleCors;

class UserCors extends HandleCors
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        $this->allowed_origins = array_merge(
            [config('app.url')],
            $user->allowed_origins
        );

        return parent::handle($request, $next);
    }
}
```

`audunru\DynamicCors\Middleware\HandleCors` has protected properties for `allowed_origins` and all the other CORS service settings. Any properties that you set in your middleware will be used by the CORS service. Properties that you don't set will use the value set in `cors.php`.

5. Add `\App\Http\Middleware\HandleCors::class` to the middleware stack.

# Development

## Testing

Run tests:

```bash
composer test
```
