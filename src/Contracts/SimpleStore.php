<?php namespace Tekton\Support\Contracts;

interface SimpleStore
{
    public function get(string $key, $default = null);

    public function set(string $key, $value);

    public function exists(string $key);

    public function has(string $key);

    public function is(string $key);
}
