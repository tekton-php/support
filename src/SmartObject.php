<?php namespace Tekton\Support;

use \Tekton\Support\Contracts\BasicPropertyTesting;
use \Tekton\Support\Contracts\AliasTranslation;
use \Tekton\Support\Contracts\UndefinedPropertyHandling;
use \Tekton\Support\Contracts\ObjectCaching;

abstract class SmartObject implements BasicPropertyTesting, AliasTranslation, UndefinedPropertyHandling, ObjectCaching {

    use \Tekton\Support\Traits\PropertyTests;
    use \Tekton\Support\Traits\ObjectPropertyCache;
    use \Tekton\Support\Traits\PropertyAliases;

    protected $get_method = null;

    // Ability to dynamically set get_method on creation
    function __construct($get_method = null) {
        if (is_callable($get_method)) {
            $this->get_method = $get_method;
        }
    }

    function get_property($key) {
        return null;
    }

    function __call($name, $args) {
        $method = '';
        $property = $name;

        // has_
        if (starts_with($name, 'has_')) {
            $property = substr($name, 4);
            $method = 'has';
        }
        // is_
        elseif (starts_with($name, 'is_')) {
            $property = substr($name, 3);
            $method = 'is';
        }

        // Translate property alias
        $property = $this->translate_alias($property);

        // Test the property
        if ( ! empty($method)) {
            return $this->{$method}($property);
        }
        else {
            $value = $this->{$property};

            if ($value) {
                // See if the property is callable
                if (is_callable($value)) {
                    return call_user_func_array($value, $args);
                }
                // Echo the property
                else {
                    echo $value;
                    return $value;
                }
            }
        }

        throw new \ErrorException('Undefined method called, "'.$name.'", on '.self::class);
    }

    function __get($key) {
        // Translate property alias
        $key = $this->translate_alias($key);

        // Get value from cache
        if ($this->cache_exists($key)) {
            return $this->cache_get($key);
        }

        // Get value of property
        if (is_callable($this->get_method)) {
            $value = $this->get_method($key);
        }
        else {
            $value = $this->get_property($key);
        }

        // Save in cache
        if ($this->cache_active()) {
            return $this->cache_set($key, $value);
        }

        return $value;
    }
}
