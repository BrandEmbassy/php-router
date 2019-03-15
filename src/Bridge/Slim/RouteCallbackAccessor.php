<?php declare(strict_types = 1);

namespace BrandEmbassy\Router\Bridge\Slim;

/**
 * @deprecated This class is here fo back compatibility only.
 */
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


    /**
     * @param mixed ...$args
     * @return mixed
     */
    public function __invoke(...$args)
    {
        return $this->getCallback()(...$args);
    }


    /**
     * @deprecated You should NEVER call this method. This is here only for back compatibility!
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
     * @return callable
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
