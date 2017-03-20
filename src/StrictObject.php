<?php namespace Tekton\Support;

class StrictObject {

    protected $_properties = array();

    function __construct($properties, $data = array()) {
        $assoc = (count(array_filter(array_keys($properties), 'is_string')) > 0) ? true : false;

        foreach ($properties as $key => $value) {
            $property = str_replace('-', '_', (($assoc) ? $key : $value));
            $value = ($assoc) ? $value : '';

            $this->_properties[$property] = true;
            $this->{$property} = $value;
        }

        foreach ($data as $key => $value) {
            if (isset($this->{$key})) {
                $this->{$key} = $value;
            }
        }
    }

    function all() {
        $properties = get_object_vars($this);
        unset($properties['_properties']);
        return $properties;
    }

    function get($key, $default = null) {
        if (isset($this->{$key})) {
            return $this->{$key};
        }

        if ( ! is_null($default)) {
            return $default;
        }
        else {
            throw new \Exception('Property "'.$key.'" is not defined');
        }
    }

    function set($key, $value) {
        if (isset($this->_properties[$key])) {
            return $this->{$key} = $value;
        }

        throw new \Exception('Property "'.$key.'" is not defined');
    }

    function __get($key) {
        return $this->get($key);
    }

    function __set($key, $value) {
        return $this->set($key, $value);
    }
}
