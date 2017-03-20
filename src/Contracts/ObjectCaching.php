<?php namespace Tekton\Support\Contracts;

interface ObjectCaching {
    function cache_set($property, $value);
    function cache_exists($property);
    function cache_get($property);
    function cache_active();
    function cache_clear($property = null);
}
