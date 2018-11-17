<?php namespace Tekton\Support;

use Tekton\Support\Manifest;

class CachedManifest extends Manifest
{
    protected $cachePath;

    public function __construct(string $path = '', string $cacheDir = '', array $manifest = [])
    {
        // Set cache dir
        if (empty($cacheDir)) {
            $cacheDir = getcwd();
        }
        else {
            $cacheDir = ensure_dir_exists(dirname($path));
        }

        // Set cache path
        if (empty($path)) {
            $this->cachePath = $cacheDir.DS.'_manifest.php';
        }
        else {
            $this->cachePath = $cacheDir.DS.'_manifest.'.pathinfo($path, PATHINFO_FILENAME).'.php';
        }

        parent::__construct($path, $manifest);
    }

    public function load()
    {
        // Mark manifest as loaded
        if ($this->loaded) {
            return;
        }
        else {
            $this->loaded = true;
        }

        if (! file_exists($this->path)) {
            return $this->manifest = [];
        }

        // See if the cached file exists
        if (file_exists($this->cachePath)) {
            // Compare and see if the cache is created after the original
            // and if it is, load the cached version
            if (filemtime($this->path) < filemtime($this->cachePath)) {
                $this->manifest = $this->parse($this->cachePath, 'php');
                return;
            }
        }

        // Return the fresh manifest and cache it for future access
        $this->manifest = $this->parse($this->path, $this->format);
        return $this->write($this->cachePath, 'php');
    }
}
