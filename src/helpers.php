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

/* ------------------------------------ */

require_once __DIR__.'/helpers/arrays.php';
require_once __DIR__.'/helpers/cache.php';
require_once __DIR__.'/helpers/colors.php';
require_once __DIR__.'/helpers/dates.php';
require_once __DIR__.'/helpers/files.php';
require_once __DIR__.'/helpers/strings.php';
