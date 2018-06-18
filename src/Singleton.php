<?php namespace Tekton\Support;

use Tekton\Support\Contracts\Singleton as SingletonContract;

class Singleton implements SingletonContract
{
    use \Tekton\Support\Traits\Singleton;
}
