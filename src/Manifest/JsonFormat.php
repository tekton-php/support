<?php namespace Tekton\Support\Manifest;

class JsonFormat extends FileFormat {

    /**
     * Read the manifest from it's storage
     * @param  mixed $uri  The URI handle
     */
    public function read(string $uri)
    {
        if ( ! file_exists($uri)) {
            return "";
        }

        return file_get_contents($uri);
    }

    /**
     * Decodes the data that was loaded with read
     * @param  mixed $data  The data to decode
     * @return mixed        The decoded data
     */
    public function decode($data)
    {
        return json_decode($data, true);
    }

    /**
     * Encodes the manifest
     * @param  array $manifest  The associative array that represents the manifest
     * @return mixed            The encoded data in whatever format write needs it
     */
    public function encode(array $manifest)
    {
        return json_encode($manifest, JSON_PRETTY_PRINT);
    }
}
