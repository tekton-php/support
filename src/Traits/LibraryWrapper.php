<?php namespace Tekton\Support\Traits;

trait LibraryWrapper {
    protected $library;

    function library() {
        return $this->library;
    }

    static function __callStatic($name, $args) {
        return forward_static_call_array(array($this->library, $name), $args);
    }

    function __call($name, $args) {
        return call_user_func_array(array($this->library, $name), $args);
    }
}
