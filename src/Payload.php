<?php

namespace Viloveul\Mutator;

use ArrayIterator;
use JsonSerializable;
use Viloveul\Mutator\Contracts\Payload as IPayload;

class Payload implements IPayload, JsonSerializable
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    /**
     * @param $key
     */
    public function __get($key)
    {
        return array_key_exists($key, $this->attributes) ? $this->attributes[$key] : null;
    }

    /**
     * @param $key
     * @param $val
     */
    public function __set($key, $val)
    {
        $this->attributes[$key] = $val;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->attributes);
    }

    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->attributes;
    }
}
