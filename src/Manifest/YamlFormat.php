<?php namespace Tekton\Support\Manifest;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class YamlFormat extends FileFormat {

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
        try {
            return Yaml::parse($data);
        }
        catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
            return [];
        }
    }

    /**
     * Encodes the manifest
     * @param  array $manifest  The associative array that represents the manifest
     * @return mixed            The encoded data in whatever format write needs it
     */
    public function encode(array $manifest)
    {
        return Yaml::dump($manifest);
    }
}
