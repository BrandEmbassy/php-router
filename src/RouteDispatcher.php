<?php declare(strict_types = 1);

namespace BrandEmbassy\Router;

use Psr\Http\Message\ServerRequestInterface;

interface RouteDispatcher
{
    public function dispatch(ServerRequestInterface $request): ?Route;
}
