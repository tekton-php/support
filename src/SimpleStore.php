<?php namespace Tekton\Support;

use Tekton\Support\Contracts\SimpleStore as SimpleStoreContract;

abstract class SimpleStore implements SimpleStoreContract
{
    abstract public function get(string $key, $default = null);

    abstract public function set(string $key, $value);

    abstract public function exists(string $key);

    public function has(string $key)
    {
        // Check if it's not empty
        if ($this->exists($key)) {
            if (! empty($this->get($key))) {
                return true;
            }
        }

        return false;
    }

    public function is(string $key)
    {
        // Check if it's truthy
        if ($this->exists($key)) {
            if ($this->get($key)) {
                return true;
            }
        }

        return false;
    }

    public function __get(string $key)
    {
        return $this->get($key);
    }

    public function __set(string $key, $value)
    {
        return $this->set($key, $value);
    }
}
