<?php namespace Tekton\Support\Contracts;

interface ManifestFormat
{
    /**
     * Read the manifest from it's storage
     * @param  mixed $uri  The URI handle
     * @return mixed       The loaded data
     */
    public function read(string $uri);

    /**
     * Decodes the data that was loaded with read
     * @param  mixed $data  The data to decode
     * @return mixed        The decoded data
     */
    public function decode($data);

    /**
     * Encodes the manifest
     * @param  array $manifest  The associative array that represents the manifest
     * @return mixed            The encoded data in whatever format write needs it
     */
    public function encode(array $manifest);

    /**
     * Write the data to the storage engine
     * @param  string $uri  The URI handle
     * @param  mixed $data  The data in whatever format encode outputted
     * @return boolean      Whether it was a successful write or not
     */
    public function write(string $uri, $data);
}
