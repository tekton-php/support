<?php namespace Tekton\Support\Traits;

trait LibraryWrapper
{
    protected $library;

    public function getLibrary()
    {
        return $this->library;
    }

    public function __call(string $method, array $args)
    {
        return call_user_func_array(array($this->library, $method), $args);
    }
}
