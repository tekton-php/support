<?php namespace Tekton\Support;

use Tekton\Support\SimpleStore;
use Tekton\Support\Contracts\Manifest as ManifestContract;
use Tekton\Support\Contracts\ManifestFormat;
use Tekton\Support\Manifest\PhpFormat;
use Tekton\Support\Manifest\JsonFormat;
use Tekton\Support\Manifest\YamlFormat;

class Manifest extends SimpleStore implements ManifestContract
{
    protected $manifest = [];
    protected $loaded = false;
    protected $path;
    protected $format;

    protected static $drivers = [];
    protected static $defaultDriver;

    public function __construct(string $path = '', array $manifest = [])
    {
        if (empty(self::$drivers)) {
            self::registerDrivers();
        }

        if (! empty($path)) {
            $this->path = $path;
            $this->format = pathinfo($this->path, PATHINFO_EXTENSION);
        }
        else {
            $this->loaded = true;
        }

        if (! empty($manifest)) {
            $this->loaded = true;
            $this->manifest = $manifest;
        }
    }

    protected static function registerDrivers()
    {
        self::extend('php', PhpFormat::class);
        self::extend('json', JsonFormat::class);

        if (class_exists('\\Symfony\\Component\\Yaml\\Yaml')) {
            self::extend('yml', YamlFormat::class);
        }

        self::$defaultDriver = 'php';
    }

    protected static function getDriver(string $format)
    {
        $format = strtolower($format);
        $driver = (isset(self::$drivers[$format]))
            ? self::$drivers[$format]
            : self::$drivers[static::$defaultDriver];

        return (is_string($driver)) ? new $driver() : $driver;
    }

    public static function extend(string $driver, $handler)
    {
        self::$drivers[$driver] = $handler;
    }

    public function get(string $key, $default = null)
    {
        $this->load();

        return (array_key_exists($key, $this->manifest)) ? $this->manifest[$key] : $default;
    }

    public function set(string $key, $value)
    {
        $this->load();

        return $this->manifest[$key] = $value;
    }

    public function remove($key)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->remove($k);
            }
        }
        elseif ($this->exists($key)) {
            $value = $this->get($key);
            unset($this->manifest[$key]);
            return $value;
        }

        return null;
    }

    public function exists(string $key)
    {
        $this->load();

        return array_key_exists($key, $this->manifest);
    }

    public function reset()
    {
        $this->loaded = false;
        $this->manifest = [];
    }

    public function all()
    {
        $this->load();

        return $this->manifest;
    }

    public function save()
    {
        $this->write($this->path, $this->format);
    }

    public function write(string $path, $format = null)
    {
        $format = strtolower($format ?? $this->format ?? 'php');
        $driver = self::getDriver($format);

        $data = $driver->encode($this->manifest);
        return $driver->write($path, $data);
    }

    public function load()
    {
        if (! $this->loaded) {
            $this->loaded = true;
            $this->manifest = $this->parse($this->path, $this->format);
        }
    }

    public function parse(string $path, $format = null)
    {
        $format = strtolower($format ?? $this->format ?? pathinfo($path, PATHINFO_EXTENSION));
        $driver = self::getDriver($format);

        $data = $driver->read($path);
        return $driver->decode($data);
    }
}
