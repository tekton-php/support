<?php namespace Tekton\Support\Contracts;

use Tekton\Support\Contracts\SimpleStore;

interface Store extends SimpleStore
{
    public function all();

    public function reset();

    public function put($key, $value = null);

    public function replace(array $attributes);

    public function remove($key);

    public function pull(string $key, $default = null);

    public function increment(string $key, $amount = 1);

    public function decrement(string $key, $amount = 1);

    public function prepend(string $key, $value);

    public function push(string $key, $value);
}
