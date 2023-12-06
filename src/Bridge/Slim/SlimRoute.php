<?php declare(strict_types = 1);

namespace BrandEmbassy\Router\Bridge\Slim;

use BrandEmbassy\Router\Route;
use Slim\Interfaces\RouteInterface;
use function assert;
use function call_user_func_array;
use function is_callable;

/**
 * @final
 */
class SlimRoute implements Route
{
    private RouteInterface $route;


    public function __construct(RouteInterface $route)
    {
        $this->route = $route;
    }


    /**
     * @param mixed  $default
     *
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


    /**
     * @param mixed $arguments
     *
     * @return mixed
     */
    public function __call(string $method, $arguments)
    {
        $callable = [$this->route, $method];
        assert(is_callable($callable));

        return call_user_func_array($callable, $arguments);
    }
}
