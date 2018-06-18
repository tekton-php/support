<?php

// Create a DS shorthand for the system directory separator
if (! defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

/* ------------------------------------ */

if (! function_exists('canonicalize')) {
    function canonicalize($address)
    {
        $address = explode('/', $address);
        $keys = array_keys($address, '..');

        foreach($keys AS $keypos => $key) {
            array_splice($address, $key - ($keypos * 2 + 1), 2);
        }

        $address = implode('/', $address);
        $address = str_replace('./', '', $address);

        return $address;
    }
}

if (! function_exists('ensure_dir_exists')) {
    function ensure_dir_exists($path, $permissions = 0775)
    {
        if (! file_exists($path)) {
            mkdir($path, $permissions, true);
        }

        return $path;
    }
}

if (! function_exists('normalize_path')) {
    function normalize_path($path)
    {
    	$path = str_replace('\\', '/', $path);
    	$path = preg_replace('|(?<=.)/+|', '/', $path);

    	if (':' === substr($path, 1, 1)) {
    		$path = ucfirst($path);
    	}

    	return $path;
    }
}

if (! function_exists('file_search')) {
    function file_search($folder, $pattern)
    {
        $dir = new \RecursiveDirectoryIterator($folder);
        $ite = new \RecursiveIteratorIterator($dir);
        $files = new \RegexIterator($ite, $pattern, \RegexIterator::GET_MATCH);
        $fileList = [];

        foreach($files as $file) {
            $fileList = array_merge($fileList, $file);
        }

        return $fileList;
    }
}

if (! function_exists('ls_files')) {
    function ls_files($root)
    {
        $rdi = new \RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS);
        $iter = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::SELF_FIRST, \RecursiveIteratorIterator::CATCH_GET_CHILD);
        $paths = [];

        foreach ($iter as $path => $dir) {
            if (! $dir->isDir()) {
                $paths[] = $path;
            }
        }

        return $paths;
    }
}

if (! function_exists('ls_dirs')) {
    function ls_dirs($root)
    {
        $rdi = new \RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS);
        $iter = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::SELF_FIRST, \RecursiveIteratorIterator::CATCH_GET_CHILD);
        $paths = [$root];

        foreach ($iter as $path => $dir) {
            if ($dir->isDir()) {
                $paths[] = $path;
            }
        }

        return $paths;
    }
}

if (! function_exists('delete_dir_contents')) {
    function delete_dir_contents($path)
    {
        if (! is_dir($path)) {
            return false;
        }

        foreach (glob($path.DS.'*') ?: [] as $file) {
            is_dir($file) ? recursive_delete($file) : unlink($file);
        }

        return true;
    }
}

if (! function_exists('include_global')) {
    function include_global($file)
    {
        include $file;
    }
}

if (! function_exists('recursive_delete')) {
    function recursive_delete($path)
    {
        if (! is_dir($path)) {
            return false;
        }

        $di = new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS);
        $ri = new \RecursiveIteratorIterator($di, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($ri as $file) {
            $file->isDir() ? rmdir($file) : unlink($file);
        }

        return rmdir($path);
    }
}

if (! function_exists('is_url')) {
    function is_url($url)
    {
        return (filter_var($url, FILTER_VALIDATE_URL)) ? true : false;
    }
}

if (! function_exists('rel_path')) {
    // Convert an absolute path to a relative
    function rel_path($uri, $compareWith)
    {
        $uri = str_replace($compareWith, '', $uri);
        return ltrim($uri, '/');
    }
}

if (! function_exists('build_url')) {
    function build_url(array $parts)
    {
        return (isset($parts['scheme']) ? "{$parts['scheme']}:" : '') .
            ((isset($parts['user']) || isset($parts['host'])) ? '//' : '') .
            (isset($parts['user']) ? "{$parts['user']}" : '') .
            (isset($parts['pass']) ? ":{$parts['pass']}" : '') .
            (isset($parts['user']) ? '@' : '') .
            (isset($parts['host']) ? "{$parts['host']}" : '') .
            (isset($parts['port']) ? ":{$parts['port']}" : '') .
            (isset($parts['path']) ? "{$parts['path']}" : '') .
            (isset($parts['query']) ? "?{$parts['query']}" : '') .
            (isset($parts['fragment']) ? "#{$parts['fragment']}" : '');
    }
}
