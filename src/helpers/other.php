<?php

if (! function_exists('is_valid')) {
    function is_valid($object)
    {
        if ($object instanceof \Tekton\Support\ValidityChecking && $object->isValid()) {
            return true;
        }
        elseif (! is_null($object)) {
            return true;
        }

        return false;
    }
}
