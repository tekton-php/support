<?php namespace Tekton\Support\Traits;

trait Singleton {

    static $instance;

    static function instance() {
        if ( ! is_null(self::$instance)) {
            return self::$instance;
        }

        return self::$instance = new static();
    }
}
