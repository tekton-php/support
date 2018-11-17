<?php

$dir = __DIR__.DS.'..'.DS.'..'.DS.'illuminate';

// Contracts (just testing arrayable)
if (! class_exists('Illuminate\\Contracts\\Support\\Arrayable')) {
    spl_autoload_register(function($class) use ($dir) {
        // namespace prefix
        $prefix = 'Illuminate\\Contracts\\Support\\';

        // base directory for the namespace prefix
        $base_dir = $dir.DS.'contracts'.DS.'Support';

        // abort if class doesn't use namespace
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }

        // get the relative class name
        $relative_class = substr($class, $len);

        // replace the namespace prefix with the base directory, replace namespace
        // separators with directory separators in the relative class name, append
        // with .php
        $file = $base_dir.DS.str_replace('\\', '/', $relative_class).'.php';

        // if the file exists, require it
        if (file_exists($file)) {
            require $file;
        }
    });
}

// Support (just testing Arr)
if (! class_exists('Illuminate\\Support\\Arr')) {
    spl_autoload_register(function($class) use ($dir) {
        // namespace prefix
        $prefix = 'Illuminate\\Support\\';

        // base directory for the namespace prefix
        $base_dir = $dir.DS.'support';

        // abort if class doesn't use namespace
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }

        // get the relative class name
        $relative_class = substr($class, $len);

        // replace the namespace prefix with the base directory, replace namespace
        // separators with directory separators in the relative class name, append
        // with .php
        $file = $base_dir.DS.str_replace('\\', '/', $relative_class).'.php';

        // if the file exists, require it
        if (file_exists($file)) {
            require $file;
        }
    });

    // Helpers
    require_once $dir.DS.'support'.DS.'helpers.php';
}
