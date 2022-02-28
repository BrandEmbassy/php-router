<?php declare(strict_types = 1);

namespace BrandEmbassy\Router;

use Psr\Http\Message\UriInterface;

interface UrlGenerator
{
    /**
     * @param string[] $params
     * @param string[] $queryParams
     */
    public function pathFor(string $routePath, array $params = [], array $queryParams = []): UriInterface;


    /**
     * @param string[] $params
     * @param string[] $queryParams
     */
    public function relativePathFor(string $routePath, array $params = [], array $queryParams = []): UriInterface;
}
