<?php declare(strict_types = 1);

namespace BrandEmbassy\Router;

interface Route
{
    /**
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getArgument(string $name, $default = null);


    public function getCallable(): callable;
}
