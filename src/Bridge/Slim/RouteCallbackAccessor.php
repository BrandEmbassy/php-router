<?php declare(strict_types = 1);

namespace BrandEmbassy\Router\Bridge\Slim;

final class RouteCallbackAccessor
{
    /**
     * @var callable
     */
    private $callbackLoader;

    /**
     * @var callable|null
     */
    private $callback;


    public function __construct(callable $callbackLoader)
    {
        $this->callbackLoader = $callbackLoader;
    }


    public function __invoke(...$args)
    {
        return $this->getCallback()(...$args);
    }


    public function getCallback(): callable
    {
        if ($this->callback === null) {
            $loader = $this->callbackLoader;
            $this->callback = $loader();
        }

        return $this->callback;
    }
}
