<?php declare(strict_types = 1);

namespace BrandEmbassy\Router\Bridge\Slim;

use PHPUnit\Framework\TestCase;
use Slim\Router;

final class SlimRouterTest extends TestCase
{
    public function testPathFor(): void
    {
        $slimRouter = new Router();
        $route = $slimRouter->map(
            ['GET'],
            '/foo/{foo}/bar/{bar}',
            function (): void {
            }
        );
        $route->setName('fooRoute');
        $router = new SlimRouter($slimRouter);

        $url = $router->pathFor('fooRoute', ['foo' => 'FOO1', 'bar' => 'BAR1'], ['baz' => 'BAZ1']);

        self::assertEquals('/foo/FOO1/bar/BAR1?baz=BAZ1', (string)$url);
    }
}
