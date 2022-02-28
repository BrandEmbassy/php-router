<?php declare(strict_types = 1);

namespace BrandEmbassy\Router\Bridge\Slim;

use BrandEmbassy\Router\Route;
use BrandEmbassy\Router\RouteDispatcher;
use BrandEmbassy\Router\UrlGenerator;
use FastRoute\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Slim\Http\Uri;
use Slim\Router;
use function assert;
use function urldecode;

/**
 * @final
 */
class SlimRouter implements RouteDispatcher, UrlGenerator
{
    private Router $router;


    public function __construct(Router $router)
    {
        $this->router = $router;
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
            assert($route instanceof \Slim\Route);
            $route->prepare($request, $routeArguments);

            return new SlimRoute($route);
        }

        return null;
    }


    /**
     * @param string[] $params
     * @param string[] $queryParams
     */
    public function pathFor(string $routePath, array $params = [], array $queryParams = []): UriInterface
    {
        return Uri::createFromString($this->router->pathFor($routePath, $params, $queryParams));
    }


    /**
     * @param string[] $params
     * @param string[] $queryParams
     */
    public function relativePathFor(string $routePath, array $params = [], array $queryParams = []): UriInterface
    {
        return Uri::createFromString($this->router->relativePathFor($routePath, $params, $queryParams));
    }
}
