<?php namespace Tekton\Support;

use BadMethodCallException;
use Tekton\Support\SimpleStore;

class SmartObject extends SimpleStore
{
    protected $data = [];
    protected $aliases = [];
    protected $_alias_lookup = [];

    public function translateAlias(string $key)
    {
        // See if aliases has been set
        if (! isset($this->aliases) || empty($this->aliases)) {
            return $key;
        }

        // Set aliases
        if (empty($this->_alias_lookup)) {
            foreach ($this->aliases as $property => $value) {
                if (! is_array($value)) {
                    $value = [$value];
                }

                foreach ($value as $alias) {
                    $this->_alias_lookup[$alias] = $property;
                }
            }
        }

        return (isset($this->_alias_lookup[$key])) ? $this->_alias_lookup[$key] : $key;
    }

    public function retrieveProperty($key = null)
    {
        return null;
    }

    public function exists(string $key)
    {
        // Translate key so that we correctly map the $key to a property name
        $key = $this->translateAlias($key);

        // Make sure it's retrieved before we test if it exists or not (DynamicObject
        // sets a key to null if it's been retrieved but wasn't found)
        if (! array_key_exists($key, $this->data)) {
            $this->data[$key] = $this->retrieveProperty($key);
        }

        // Test if it's set or if it's null
        return isset($this->data[$key]);
    }

    public function get(string $key, $default = null)
    {
        // Translate key so that we correctly map the $key to a property name
        $key = $this->translateAlias($key);

        // Make sure it's retrieved before we test if it exists or not (DynamicObject
        // sets a key to null if it's been retrieved but wasn't found)
        if (! array_key_exists($key, $this->data)) {
            $this->data[$key] = $this->retrieveProperty($key);
        }

        // Validate object before returning
        if (isset($this->data[$key])) {
            // If it is not a valid object we can make life a lot easier by
            // setting it to null instead
            if ($this->data[$key] instanceof ValidityChecking && ! $this->data[$key]->isValid()) {
                $this->data[$key] = null;
            }
        }

        // Return default if the data is null
        return $this->data[$key] ?? $default;
    }

    public function set(string $key, $value)
    {
        // Translate key so that we correctly map the $key to a property name
        $key = $this->translateAlias($key);

        $this->data[$key] = $value;

        return $this;
    }

    function __toString()
    {
        return $this->get(null, '');
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
