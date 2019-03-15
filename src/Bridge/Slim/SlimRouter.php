<?php declare(strict_types = 1);

namespace BrandEmbassy\Router\Bridge\Slim;

use BrandEmbassy\Router\Route;
use BrandEmbassy\Router\Router;
use FastRoute\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Slim\Http\Uri;
use Slim\Interfaces\RouteInterface;
use function array_map;
use function assert;
use function urldecode;

final class SlimRouter implements Router
{
    /**
     * @var \Slim\Router
     */
    private $router;


    public function __construct(\Slim\Router $router)
    {
        $this->router = $router;
    }


    /**
     * @param string   $routePath
     * @param string[] $params
     * @param string[] $queryParams
     * @return UriInterface
     */
    public function pathFor(string $routePath, array $params = [], array $queryParams = []): UriInterface
    {
        return Uri::createFromString($this->router->pathFor($routePath, $params, $queryParams));
    }


    /**
     * @param string   $name
     * @param string[] $methods
     * @param string   $pattern
     * @param callable $handler
     */
    public function map(string $name, array $methods, string $pattern, callable $handler): void
    {
        $route = $this->router->map($methods, $pattern, $handler);
        $route->setName($name);
    }


    public function dispatch(ServerRequestInterface $request): ?Route
    {
        $routeInfo = $this->router->dispatch($request);
        if ($routeInfo[0] === Dispatcher::FOUND) {
            $routeArguments = [];
            foreach ($routeInfo[2] as $k => $v) {
                $routeArguments[$k] = urldecode($v);
            }

            $route = $this->router->lookupRoute($routeInfo[1]);
            assert($route instanceof Route);
            $route->prepare($request, $routeArguments);

            return new SlimRoute($route);
        }

        return null;
    }


    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return array_map(
            function (RouteInterface $route): Route {
                return new SlimRoute($route);
            },
            $this->router->getRoutes()
        );
    }
}
