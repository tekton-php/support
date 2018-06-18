<?php namespace Tekton\Support;

use ArrayAccess;
use Illuminate\Support\Arr;
use Tekton\Support\Store;

class Repository extends Store implements ArrayAccess
{
    protected $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function reset()
    {
        $this->data = [];
    }

    public function all()
    {
        return $this->data;
    }

    public function exists(string $key)
    {
        return Arr::has($this->data, $key);
    }

    public function get(string $key, $default = null)
    {
        return Arr::get($this->data, $key, $default);
    }

    public function set(string $key, $value = null)
    {
        Arr::set($this->data, $key, $value);

        return $this;
    }

    public function remove($key)
    {
        Arr::forget($this->data, $key);

        return null;
    }

    public function offsetExists($key)
    {
        return $this->exists($key);
    }

    public function offsetGet($key)
    {
        return $this->get($key);
    }

    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    public function offsetUnset($key)
    {
        $this->set($key, null);
    }
}
