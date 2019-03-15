<?php declare(strict_types = 1);

namespace BrandEmbassy\Router\Bridge\Slim;

use BrandEmbassy\Router\Route;
use Slim\Interfaces\RouteInterface;
use function assert;

final class SlimRoute implements Route
{
    /**
     * @var RouteInterface
     */
    private $route;


    public function __construct(RouteInterface $route)
    {
        $this->route = $route;
    }


    /**
     * @param string $name
     * @param mixed  $default
     * @return mixed
     */
    public function getArgument(string $name, $default = null)
    {
        return $this->route->getArgument($name, $default);
    }


    public function getCallable(): callable
    {
        assert($this->route instanceof \Slim\Route);

        return $this->route->getCallable();
    }
}
