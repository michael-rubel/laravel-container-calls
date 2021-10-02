<?php

declare(strict_types=1);

use MichaelRubel\EnhancedContainer\Call;
use MichaelRubel\EnhancedContainer\Core\BindingBuilder;

if (! function_exists('call')) {
    /**
     * @param string|object $class
     * @param array         $parameters
     *
     * @return mixed
     */
    function call(string|object $class, array $parameters = []): mixed
    {
        return app(Call::class, [$class, $parameters]);
    }
}

if (! function_exists('bind')) {
    /**
     * @param string|object $abstract
     *
     * @return BindingBuilder
     */
    function bind(string|object $abstract): BindingBuilder
    {
        return new BindingBuilder($abstract);
    }
}
