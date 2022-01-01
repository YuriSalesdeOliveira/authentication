<?php

namespace Source\Model\Trait;

trait Attributes
{
    protected array $attributes;

    public function _construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function __get($key)
    {
        return $this->attributes[$key];
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function __isset($key): bool
    {
        return isset($this->attributes[$key ]);
    }

    public function __unset($key): void
    {
        unset($this->attributes[$key]);
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}