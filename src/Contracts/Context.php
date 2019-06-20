<?php

namespace Viloveul\Mutator\Contracts;

use Closure;
use Viloveul\Mutator\Contracts\Payload;

interface Context
{
    /**
     * @param string  $name
     * @param Closure $handler
     * @param int     $priority
     */
    public function addHandler(string $name, Closure $handler, int $priority): void;

    /**
     * @param string  $name
     * @param Payload $payload
     */
    public function apply(string $name, Payload $payload): Payload;

    /**
     * @param string $name
     */
    public function hasHandler(string $name): bool;
}
