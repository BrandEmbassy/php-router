<?php declare(strict_types = 1);

namespace BrandEmbassy\Router;

use Psr\Http\Message\ServerRequestInterface;
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


    /**
     * @param string   $name
     * @param string[] $methods
     * @param string   $pattern
     * @param callable $handler
     */
    public function map(string $name, array $methods, string $pattern, callable $handler): void;


    public function dispatch(ServerRequestInterface $request): ?Route;


    /**
     * @return Route[]
     */
    public function getRoutes(): array;
}
