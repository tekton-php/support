<?php namespace Tekton\Support;

use Tekton\Support\SimpleStore;
use Tekton\Support\Contracts\Store as StoreContract;

class Store extends SimpleStore implements StoreContract
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

    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function set(string $key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function exists(string $key)
    {
        return array_key_exists($key, $this->data);
    }

    public function remove($key)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->remove($k);
            }
        }
        elseif ($this->exists($key)) {
            $value = $this->data[$key];
            unset($this->data[$key]);
            return $value;
        }

        return null;
    }

    public function put($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->set($k, $v);
            }
        }
        else {
            $this->set($key, $value);
        }

        return $this;
    }

    public function replace(array $attributes)
    {
        $this->put($attributes);

        return $this;
    }

    public function pull(string $key, $default = null)
    {
        if (! $this->exists($key)) {
            return $default;
        }

        return $this->remove($key);
    }

    public function increment(string $key, $amount = 1)
    {
        $this->put($key, $value = $this->get($key, 0) + $amount);

        return $value;
    }

    public function decrement(string $key, $amount = 1)
    {
        return $this->increment($key, $amount * -1);
    }

    public function prepend(string $key, $value)
    {
        $array = $this->get($key);
        array_unshift($array, $value);
        $this->set($key, $array);

        return $this;
    }

    public function push(string $key, $value)
    {
        $array = $this->get($key);
        $array[] = $value;
        $this->set($key, $array);

        return $this;
    }
}
