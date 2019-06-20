<?php

namespace Viloveul\Mutator;

use Closure;
use ReflectionFunction;
use InvalidArgumentException;
use Viloveul\Mutator\Contracts\Payload as IPayload;
use Viloveul\Mutator\Contracts\Context as IContext;

class Context implements IContext
{
    /**
     * @var array
     */
    protected $handlers = [];

    /**
     * @param string  $name
     * @param Closure $handler
     * @param int     $priority
     */
    public function addHandler(string $name, Closure $handler, int $priority = 10): void
    {
        $this->check(new ReflectionFunction($handler));
        if (!$this->hasHandler($name)) {
            $this->handlers[$name] = [];
        }
        $id = spl_object_hash($handler) . $priority;
        if (isset($this->handlers[$name][$priority][$id])) {
            throw new InvalidArgumentException("Handler already registered.");
        }
        $this->handlers[$name][$priority][$id] = $handler;
    }

    /**
     * @param  string   $name
     * @param  IPayload $payload
     * @return mixed
     */
    public function apply(string $name, IPayload $payload): IPayload
    {
        $result = clone $payload;

        if ($handlers = $this->catch($name)) {
            do {
                foreach ((array) current($handlers) as $callback):
                    $filtered = call_user_func($callback, $result, $payload, $this, $name);
                    if ($filtered !== null) {
                        $result = $filtered;
                    }
                endforeach;

            } while (false !== next($handlers));
        }

        return $result;
    }

    /**
     * @param string $name
     */
    public function hasHandler(string $name): bool
    {
        return array_key_exists($name, $this->handlers) && count($this->handlers[$name]) > 0;
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
        if ($paramType === null || $paramType->getName() !== IPayload::class) {
            throw new InvalidArgumentException("Argument must accept Payload interface");
        }
    }

    /**
     * @param  string  $name
     * @return mixed
     */
    protected function catch(string $name): array
    {
        if (!$this->hasHandler($name)) {
            return [];
        }

        $handlers = $this->handlers[$name];

        // sort by key (its mean about priority)
        ksort($handlers);

        return $handlers;
    }
}
