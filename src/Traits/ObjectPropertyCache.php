<?php namespace Tekton\Support\Traits;

trait ObjectPropertyCache {

    protected $propertyCache = true;
    protected $_propertyCacheStore = array();

    function cache_active() {
        return $this->propertyCache;
    }

    function cache_set($property, $value) {
        if ($this->cache_active()) {
            return $this->_propertyCacheStore[$property] = $value;
        }

        return null;
    }

    function cache_exists($property) {
        if ( ! $this->cache_active()) {
            return false;
        }

        return isset($this->_propertyCacheStore[$property]);
    }

    function cache_get($property) {
        if ( ! $this->cache_active()) {
            return null;
        }

        if (isset($this->_propertyCacheStore[$property])) {
            return $this->_propertyCacheStore[$property];
        }
        else {
            return null;
        }
    }

    function cache_clear($property = null) {
        if (is_null($property)) {
            $this->_propertyCacheStore = array();
        }
        elseif (isset($this->_propertyCacheStore[$property])) {
            unset($this->_propertyCacheStore[$property]);
        }
    }
}
