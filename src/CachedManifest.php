<?php namespace Tekton\Support;

use Tekton\Support\Manifest;

class CachedManifest extends Manifest {

    protected $cachePath;

    function __construct($id, $cacheDir, $manifest = []) {
        $this->cacheDir = $cacheDir;
        $this->cachePath = $cacheDir.DS.'manifest'.DS.$id.'.php';

        parent::__construct($id, $manifest);
    }

    function load($path) {
        if ( ! file_exists($path)) {
            return $this->manifest = [];
        }
        
        // The cache is based on file modification time and compares the cached
        // manifest with the real manifest
        $manifestTime = filemtime($path);

        // If the cache is up to date we return that one
        if (file_exists($this->cachePath)) {
            if (filemtime($this->cachePath) == $manifestTime) {
                return $this->manifest = $this->parse($this->cachePath);
            }
        }

        // Return the fresh manifest and cache it for future access
        $this->manifest = $this->parse($path);
        $this->write($this->cachePath, 'php');

        // Set modification time of the cache file to the same as the source file
        touch($this->cachePath, $manifestTime);

        return $this->manifest;
    }
}
