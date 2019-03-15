<?php declare(strict_types = 1);

namespace BrandEmbassy\Router\Bridge\Slim;

use BrandEmbassy\Router\Router;
use Psr\Http\Message\UriInterface;
use Slim\Http\Uri;

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
}
