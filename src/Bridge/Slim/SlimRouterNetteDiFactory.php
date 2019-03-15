<?php declare(strict_types = 1);

namespace BrandEmbassy\Router\Bridge\Slim;

use BrandEmbassy\Router\Router;
use LogicException;
use Nette\DI\Container;
use function explode;
use function is_callable;
use function sprintf;
use function strtolower;

final class SlimRouterNetteDiFactory
{
    private const METHOD_DELIMITER = '|';


    /**
     * @param Container $container
     * @param string    $namespace
     * @param mixed[]   $routes
     * @return Router
     */
    public static function createRouter(Container $container, string $namespace, array $routes): Router
    {
        $router = new SlimRouter(new \Slim\Router());

        $routes = self::getAppRoutes($namespace, $routes);
        foreach ($routes as $pattern => $definition) {
            foreach ($definition as $method => $data) {
                if (!isset($data['name'])) {
                    throw new LogicException(sprintf('Route with pattern: "%s" must have name.', $pattern));
                }
                $router->map(
                    $data['name'],
                    explode(self::METHOD_DELIMITER, $method),
                    $pattern,
                    self::getService($container, $data['service'])
                );
            }
        }

        return $router;
    }


    /**
     * @param string  $namespace
     * @param mixed[] $routes
     * @return mixed[]
     */
    private static function getAppRoutes(string $namespace, array $routes): array
    {
        $namespace = strtolower($namespace);

        return $routes[$namespace] ?? [];
    }


    private static function getService(Container $container, string $identifier): callable
    {
        $service = $container->getByType($identifier, false);
        if ($service === null) {
            $service = $container->getService($identifier);
        }

        if (!is_callable($service)) {
            throw new LogicException(sprintf('Service "%s" must be callable.', $identifier));
        }

        return $service;
    }
}
