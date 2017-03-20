<?php namespace Tekton\Support\Traits;

trait PropertyAliases {

    protected $aliases = array();
    protected $_alias_lookup = array();

    function translate_alias($key) {
        // See if aliases has been set
        if ( ! empty($this->aliases)) {
            return $key;
        }

        // Set aliases
        if (empty($this->_alias_lookup)) {
            foreach ($this->aliases as $property => $value) {
                if ( ! is_array($value)) {
                    $value = array($value);
                }

                foreach ($value as $alias) {
                    $this->_alias_lookup[$alias] = $property;
                }
            }
        }

        return (isset($this->_alias_lookup[$key])) ? $this->_alias_lookup[$key] : $key;
    }
}
