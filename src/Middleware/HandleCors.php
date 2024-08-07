<?php

namespace audunru\DynamicCors\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Middleware\HandleCors as MiddlewareHandleCors;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
abstract class HandleCors extends MiddlewareHandleCors
{
    private const PATHS_KEY = 'cors.paths';
    private const ALLOWED_METHODS_KEY = 'cors.allowed_methods';
    private const ALLOWED_ORIGINS_KEY = 'cors.allowed_origins';
    private const ALLOWED_ORIGINS_PATTERNS_KEY = 'cors.allowed_origins_patterns';
    private const ALLOWED_HEADERS_KEY = 'cors.allowed_headers';
    private const EXPOSED_HEADERS_KEY = 'cors.exposed_headers';
    private const MAX_AGE_KEY = 'cors.max_age';
    private const SUPPORTS_CREDENTIALS_KEY = 'cors.supports_credentials';

    /**
     * Paths determine if the CORS service should run.
     */
    protected ?array $paths;

    /**
     * The Access-Control-Allow-Methods response header specifies one or more methods allowed
     * when accessing a resource in response to a preflight request.
     * https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Methods.
     */
    protected ?array $allowedMethods;

    /**
     * The Access-Control-Allow-Origin response header indicates whether the response can be
     * shared with requesting code from the given origin.
     * https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin.
     */
    protected ?array $allowedOrigins;

    /**
     * Same as $allowed_origins, but uses regex patterns to make the match.
     */
    protected ?array $allowedOriginsPatterns;

    /**
     * The Access-Control-Allow-Headers response header is used in response to a preflight
     * request which includes the Access-Control-Request-Headers to indicate which HTTP
     * headers can be used during the actual request.
     * https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Headers.
     */
    protected ?array $allowedHeaders;

    /**
     * The Access-Control-Expose-Headers response header allows a server to indicate which
     * response headers should be made available to scripts running in the browser, in
     * response to a cross-origin request.
     * https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Expose-Headers.
     */
    protected ?array $exposedHeaders;

    /**
     * The Access-Control-Max-Age response header indicates how long the results of a preflight
     * request (that is the information contained in the Access-Control-Allow-Methods and
     * Access-Control-Allow-Headers headers) can be cached.
     * https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Max-Age.
     */
    protected ?int $maxAge;

    /**
     * The Access-Control-Allow-Credentials response header tells browsers whether the server
     * allows cross-origin HTTP requests to include credentials.
     * https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Credentials.
     */
    protected ?bool $supportsCredentials;

    public function handle(Request $request, Closure $next)
    {
        $this->setCorsOptions();

        return parent::handle($request, $next);
    }

    private function setCorsOptions(): void
    {
        config([
            self::PATHS_KEY                    => $this->getPaths(),
            self::ALLOWED_METHODS_KEY          => $this->getAllowedMethods(),
            self::ALLOWED_ORIGINS_KEY          => $this->getAllowedOrigins(),
            self::ALLOWED_ORIGINS_PATTERNS_KEY => $this->getAllowedOriginsPatterns(),
            self::ALLOWED_HEADERS_KEY          => $this->getAllowedHeaders(),
            self::EXPOSED_HEADERS_KEY          => $this->getExposedHeaders(),
            self::MAX_AGE_KEY                  => $this->getMaxAge(),
            self::SUPPORTS_CREDENTIALS_KEY     => $this->getSupportsCredentials(),
        ]);

        $this->cors->setOptions(config('cors', []));
    }

    private function getPaths(): array
    {
        return $this->paths ?? config(self::PATHS_KEY);
    }

    private function getAllowedMethods(): array
    {
        return $this->allowedMethods ?? config(self::ALLOWED_METHODS_KEY);
    }

    private function getAllowedOrigins(): array
    {
        return $this->allowedOrigins ?? config(self::ALLOWED_ORIGINS_KEY);
    }

    private function getAllowedOriginsPatterns(): array
    {
        return $this->allowedOriginsPatterns ?? config(self::ALLOWED_ORIGINS_PATTERNS_KEY);
    }

    private function getAllowedHeaders(): array
    {
        return $this->allowedHeaders ?? config(self::ALLOWED_HEADERS_KEY);
    }

    private function getExposedHeaders(): array
    {
        return $this->exposedHeaders ?? config(self::EXPOSED_HEADERS_KEY);
    }

    private function getMaxAge(): int
    {
        return $this->maxAge ?? config(self::MAX_AGE_KEY);
    }

    private function getSupportsCredentials(): bool
    {
        return $this->supportsCredentials ?? config(self::SUPPORTS_CREDENTIALS_KEY);
    }
}
