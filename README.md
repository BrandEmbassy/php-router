# Router
Router interface for interoperability between Brand Embassy libraries and services.

## Install
```bash
composer require brandembassy/php-router
```

## Usage
Two interfaces:

1) `RouteDispatcher` for dispatching PSR request.
2) `UrlGenerator` for generating URLs for links in application.

## Bridges

### Slim Framework with NetteDI
First in your `parameters` in `.neon` config file you need to specify routes. Structure
is demonstrated by following example:

```bash
parameters:
    app:
        routes:
            backOffice: # namespace, just for organization no semantic meaning
                "/back-office/brand/{brandId}/create-user":
                    "get|post": # you can specify multiple HTTP methods
                        name: backOfficeCreateUserInBrand # Name is mandatory and is used as identifier
                        service: BrandEmbassy/App/BackOffice/User/CreateUserInBrandActoon # This service must be callable (must have __invoke() method)
```

Then in your `services.neon` you just register services:
```yml

urlGenerator:
        class: BrandEmbassy\Router\UrlGenerator
        factory: BrandEmbassy\Router\Bridge\Slim\SlimRouterNetteDiFactory::create(..., %app.routes%)

routeDispatcher:
    class: BrandEmbassy\Router\RouteDispatcher
    factory: BrandEmbassy\Router\Bridge\Slim\SlimRouterNetteDiFactory::create(..., %app.routes%)
```
