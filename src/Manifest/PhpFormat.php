<?php namespace Tekton\Support\Manifest;

class PhpFormat extends FileFormat {

    /**
     * Read the manifest from it's storage
     * @param  mixed $uri  The URI handle
     */
    public function read(string $uri)
    {
        if ( ! file_exists($uri)) {
            return [];
        }

        return include $uri;
    }

    /**
     * Decodes the data that was loaded with read
     * @param  mixed $data  The data to decode
     * @return mixed        The decoded data
     */
    public function decode($data)
    {
        return $data;
    }

    /**
     * Encodes the manifest
     * @param  array $manifest  The associative array that represents the manifest
     * @return mixed            The encoded data in whatever format write needs it
     */
    public function encode(array $manifest)
    {
        return '<?php return '.var_export($manifest, true).';';
    }
}
