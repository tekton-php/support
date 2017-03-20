<?php namespace Tekton\Support\Traits;

trait PropertyAccessibleMethods {
    function __get($key) {
        // Translate aliases
        if ($this instanceof \Tekton\Support\PropertyAliases) {
            $key = $this->translate_alias($key);
        }

        // Check if value is set in cache
        if ($this instanceof \Tekton\Support\ObjectCaching && $this->cache_exists($key)) {
            return $this->cache_get($key);
        }

        // Get value
        if (method_exists($this, $key)) {
            $value = call_user_func(array($this, $key));
        }
        else {
            if ($this instanceof \Tekton\Support\UndefinedPropertyHandler) {
                $value = $this->get_property($key);
            }
            else {
                throw new \ErrorException('Undefined property, "'.$key.'", on '.self::class);
            }
        }

        // Set value to cache
        if ($this instanceof \Tekton\Support\ObjectCaching && $this->cache_active()) {
            return $this->cache_set($key, $value);
        }

        return $value;
    }
}
