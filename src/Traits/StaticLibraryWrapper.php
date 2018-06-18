<?php namespace Tekton\Support\Traits;

trait StaticLibraryWrapper
{
    protected static $library;

    public static function getLibrary()
    {
        return self::$library;
    }

    public static function __callStatic($method, string $args)
    {
        return forward_static_call_array(array(self::$library, $method), $args);
    }
}
