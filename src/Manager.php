<?php

namespace Viloveul\Mutator;

use Closure;
use ReflectionFunction;
use InvalidArgumentException;
use Viloveul\Mutator\Contracts\Context as IContext;
use Viloveul\Mutator\Contracts\Manager as IManager;

class Manager implements IManager
{
    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @param string  $name
     * @param Closure $handler
     * @param int     $priority
     */
    public function addFilter(string $name, Closure $handler, int $priority = 10): void
    {
        $this->check(new ReflectionFunction($handler));
        if (!$this->hasFilter($name)) {
            $this->filters[$name] = [];
        }
        $id = spl_object_hash($handler) . $priority;
        if (isset($this->filters[$name][$priority][$id])) {
            throw new InvalidArgumentException("Filter already registered.");
        }
        $this->filters[$name][$priority][$id] = $handler;
    }

    /**
     * @param  string   $name
     * @param  IContext $payload
     * @return mixed
     */
    public function apply(string $name, IContext $payload): IContext
    {
        $result = clone $payload;

        $filters = $this->fill($name);

        do {
            foreach ((array) current($filters) as $callback):
                $filtered = call_user_func($callback, $result, $payload);
                if ($filtered !== null) {
                    $result = $filtered;
                }
            endforeach;

        } while (false !== next($filters));

        return $result;
    }

    /**
     * @param string $name
     */
    public function hasFilter(string $name): bool
    {
        return array_key_exists($name, $this->filters) && count($this->filters[$name]) > 0;
    }

    /**
     * @param ReflectionFunction $ref
     */
    protected function check(ReflectionFunction $ref): void
    {
        if ($ref->getNumberOfParameters() === 0) {
            throw new InvalidArgumentException("No such argument for handler");
        }
        $params = $ref->getParameters();
        $paramType = $params[0]->getType();
        if ($paramType === null || $paramType->getName() !== IContext::class) {
            throw new InvalidArgumentException("Argument must accept Context interface");
        }
    }

    /**
     * @param  string  $name
     * @return mixed
     */
    protected function fill(string $name): array
    {
        if (!$this->hasFilter($name)) {
            return [];
        }

        $filters = $this->filters[$name];

        // sort by key (its mean about priority)
        ksort($filters);

        return $filters;
    }
}
