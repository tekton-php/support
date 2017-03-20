<?php namespace Tekton\Support\Contracts;

interface Manifest {

    function get($key, $default = null);

    function set($key, $value);

    function has($key);

    function write($path, $format = 'php');

    function load($path);

    function parse($path);
}
