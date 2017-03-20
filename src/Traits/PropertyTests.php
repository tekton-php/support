<?php namespace Tekton\Support\Traits;

trait PropertyTests {

    function has($property) {
        // Translate property alias
        if ($this instanceof \Tekton\Support\PropertyAliases) {
            $property = $this->translate_alias($property);
        }

        // See if the property exists
        try {
            $property = $this->{$property};
        }
        catch (\ErrorException $exception) {
            return false;
        }

        // Make sure that the object has been created successfully
        if ($property instanceof \Tekton\Support\ValidityCheck && ! $property->is_valid()) {
            return false;
        }

        return (! empty($property)) ? true : false;
    }

    function is($property) {
        // Translate property alias
        if ($this instanceof \Tekton\Support\PropertyAliases) {
            $property = $this->translate_alias($property);
        }

        // See if the property exists
        try {
            $property = $this->{$property};
        }
        catch (\ErrorException $exception) {
            return false;
        }

        // Make sure that the object has been created successfully
        if ($property instanceof \Tekton\Support\ValidityCheck && ! $property->is_valid()) {
            return false;
        }

        return ($property) ? true : false;
    }
}
