<?php declare(strict_types = 1);

namespace BrandEmbassy\Router;

use Psr\Http\Message\UriInterface;

interface Router
{
    /**
     * @param string   $routePath
     * @param string[] $params
     * @param string[] $queryParams
     * @return UriInterface
     */
    public function pathFor(string $routePath, array $params = [], array $queryParams = []): UriInterface;
}
