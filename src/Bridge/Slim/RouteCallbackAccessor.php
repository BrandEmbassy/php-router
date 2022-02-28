<?php declare(strict_types = 1);

namespace BrandEmbassy\Router\Bridge\Slim;

use function is_callable;

/**
 * @deprecated This class is here fo back compatibility only.
 *
 * @final
 */
class RouteCallbackAccessor
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


    /**
     * @param mixed ...$args
     *
     * @return mixed
     */
    public function __invoke(...$args)
    {
        $callback = $this->getCallback();
        if (!is_callable($callback)) {
            return 'ERROR!';
        }

        return $callback(...$args);
    }


    /**
     * @deprecated You should NEVER call this method. This is here only for back compatibility!
     *
     * @return callable|object
     */
    public function getCallback()
    {
        if ($this->callback === null) {
            $loader = $this->callbackLoader;
            $this->callback = $loader();
        }

        return $this->callback;
    }
}
