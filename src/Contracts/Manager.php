<?php

namespace Viloveul\Mutator\Contracts;

use Closure;
use Viloveul\Mutator\Contracts\Context;

interface Manager
{
    /**
     * @param string  $name
     * @param Closure $handler
     * @param int     $priority
     */
    public function addFilter(string $name, Closure $handler, int $priority): void;

    /**
     * @param string  $name
     * @param Context $payload
     */
    public function apply(string $name, Context $payload): Context;

    /**
     * @param string $name
     */
    public function hasFilter(string $name): bool;
}
