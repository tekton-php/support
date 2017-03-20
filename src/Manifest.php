<?php namespace Tekton\Support;

use Tekton\Support\Contracts\Manifest as ManifestContract;
use ErrorException;

class Manifest implements ManifestContract {

    protected $manifest = [];
    protected $id;

    function __construct($id, $manifest = []) {
        $this->id = $id;

        if (is_string($manifest)) {
            $this->load($manifest);
        }
        elseif (is_assoc($manifest)) {
            $this->manifest = $manifest;
        }
    }

    function get($key, $default = null) {
        return (isset($manifest[$key])) ? $manifest[$key] : $default;
    }

    function set($key, $value) {
        return $this->manifest[$key] = $value;
    }

    function has($key) {
        return (isset($manifest[$key])) ? true : false;
    }

    function write($path, $format = 'php') {
        if ($format == 'json') {
            $data = json_encode($this->manifest);
        }
        else {
            $data = '<?php return '.var_export($this->manifest, true).';';
        }

        // If the directory for the file doesn't exist we create it recursively
        if ( ! file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        // Write file to target directory
        if ( ! file_put_contents($path, $data)) {
            throw new ErrorException("Failed to write output to file: ".$path);
        }
    }

    function load($path) {
        return $this->parse($path);
    }

    function parse($path) {
        if ( ! file_exists($path)) {
            return [];
        }

        $manifestExt = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if ($manifestExt == 'json') {
            return json_decode(file_get_contents($path), true);
        }
        elseif ($manifestExt == 'php') {
            return include $path;
        }

        return [];
    }
}
