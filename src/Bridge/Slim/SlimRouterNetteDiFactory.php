<?php declare(strict_types = 1);

namespace BrandEmbassy\Router\Bridge\Slim;

use BrandEmbassy\Router\RouteDispatcher;
use LogicException;
use Nette\DI\Container;
use Slim\Router;
use function explode;
use function sprintf;

/**
 * @final
 */
class SlimRouterNetteDiFactory
{
    private const METHOD_DELIMITER = '|';


    /**
     * @param mixed[]   $routes
     */
    public static function create(Container $container, array $routes): RouteDispatcher
    {
        $router = self::createSlimRouter($container, $routes);

        return new SlimRouter($router);
    }


    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
     */
    private static function getService(Container $container, string $identifier): callable
    {
        $service = $container->getByType($identifier, false);
        if ($service === null) {
            $service = $container->getService($identifier);
        }

        return $service;
    }


    /**
     * @param mixed[]   $routes
     */
    private static function createSlimRouter(Container $container, array $routes): Router
    {
        $router = new Router();

        foreach ($routes as $namespace => $namespacedRoutes) {
            foreach ($namespacedRoutes as $pattern => $definition) {
                foreach ($definition as $method => $data) {
                    if (!isset($data['name'])) {
                        throw new LogicException(sprintf('Route with pattern: "%s" must have name.', $pattern));
                    }

                    $callbackProvider = function () use ($container, $data) {
                        return self::getService($container, $data['service']);
                    };

                    $route = $router->map(
                        explode(self::METHOD_DELIMITER, $method),
                        $pattern,
                        new RouteCallbackAccessor($callbackProvider)
                    );
                    $route->setName($data['name']);
                }
            }
        }

        return $router;
    }
}
