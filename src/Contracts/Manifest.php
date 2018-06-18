<?php namespace Tekton\Support\Contracts;

use Tekton\Support\Contracts\SimpleStore;

interface Manifest extends SimpleStore
{
    public function save();

    public function write(string $path, $format = null);

    public function load();

    public function parse(string $path, $format = null);
}
