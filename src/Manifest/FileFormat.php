<?php namespace Tekton\Support\Manifest;

use \Tekton\Support\Contracts\ManifestFormat;
use ErrorException;

abstract class FileFormat implements ManifestFormat {

    /**
     * Read the manifest from it's storage
     * @param  mixed $uri  The URI handle
     */
    abstract function read(string $uri);

    /**
     * Decodes the data that was loaded with read
     * @param  mixed $data  The data to decode
     * @return mixed        The decoded data
     */
    abstract function decode($data);

    /**
     * Encodes the manifest
     * @param  array $manifest  The associative array that represents the manifest
     * @return mixed            The encoded data in whatever format write needs it
     */
    abstract function encode(array $manifest);

    /**
     * Write the data to the storage engine
     * @param  string $uri  The URI handle
     * @param  mixed $data  The data in whatever format encode outputted
     * @return boolean      Whether it was a successful write or not
     */
    public function write(string $uri, $data)
    {
        // Create directory recursively if it doesn't exist
        if ( ! file_exists(dirname($uri))) {
            mkdir(dirname($uri), 0755, true);
        }

        // Write file to target directory
        if ( ! file_put_contents($uri, $data)) {
            throw new ErrorException("Failed to write output to file: ".$uri);
        }

        return true;
    }
}
