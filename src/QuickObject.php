<?php namespace Tekton\Support;

use ErrorException;
use Tekton\Support\SimpleStore;

class QuickObject extends SimpleStore
{
    protected $data = [];
    protected $defaults = [];

    public function __construct(array $properties, array $data = [])
    {
        // If properties is an associative array we use the values as the default
        // value for the property and then replace it with $data if its key is set
        $assoc = is_assoc($properties);

        // Set all the object's properties
        foreach ($properties as $key => $value) {
            $property = str_replace('-', '_', (($assoc) ? $key : $value));
            $value = ($assoc) ? $value : null;

            if (! is_null($value)) {
                $this->defaults[$property] = $value;
            }

            $this->data[$property] = $value;
        }

        // Set data
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->data)) {
                $this->data[$key] = $value;
            }
        }
    }

    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function set(string $key, $value)
    {
        if (array_key_exists($key, $this->data)) {
            $this->data[$key] = $value;
        }
        else {
            throw new ErrorException('Property "'.$key.'" is not defined');
        }

        return $this;
    }

    public function extend(string $key, $value = null)
    {
        if (! array_key_exists($key, $this->data)) {
            $this->data[$key] = $value;
        }

        return $this;
    }

    public function exists(string $key)
    {
        return array_key_exists($key, $this->data);
    }

    public function all()
    {
        return $this->data;
    }

    public function reset()
    {
        $this->data = [];

        foreach ($this->data as $key => $value) {
            if (array_key_exists($key, $this->defaults)) {
                $this->data[$key] = $this->defaults[$key];
            }
            else {
                $this->data[$key] = null;
            }
        }
    }

    public function make($data = [])
    {
        $copy = clone $this;
        $copy->reset();

        if (! empty($data)) {
            $copy->put($data);
        }

        return $copy;
    }

    public function __call(string $method, array $args)
    {
        if (! is_null($value = $this->get($method, null))) {
            // Make sure it's callable
            if (is_callable($value)) {
                return call_user_func_array($value, $args);
            }
        }
        else {
            throw new BadMethodCallException("The method $method doesn't exist on ".get_class($this));
        }
    }
}
