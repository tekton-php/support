<?php

if (! function_exists('array_mirror')) {
    function array_mirror($values)
    {
        return array_combine($values, $values);
    }
}

if (! function_exists('camel_keys')) {
    function camel_keys($array)
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = camel_keys($value);
            }
            $result[camel_case($key)] = $value;
        }

        return $result;
    }
}

if (! function_exists('snake_keys')) {
    function snake_keys($array, $delimiter = '_')
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = snake_keys($value);
            }
            $result[snake_case($key, $delimiter)] = $value;
        }

        return $result;
    }
}

if (! function_exists('is_assoc')) {
    function is_assoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}

if (! function_exists('is_iterable')) {
    function is_iterable($var)
    {
        return (is_array($var) || $var instanceof Traversable || $var instanceof stdClass);
    }
}
