<?php

if (! function_exists('write_object_to_file')) {
    function write_object_to_file(string $path, $items)
    {
        $output = '<?php return '.var_export($items, true).';';

        // Write file to target directory
        write_string_to_file($path, $output);
    }
}

if (! function_exists('write_string_to_file')) {
    function write_string_to_file(string $path, string $content)
    {
        if (empty($content)) {
            if (! touch($path)) {
                throw new \ErrorException('Failed to create file: '.$path);
            }
        }
        else {
            // Write file to target directory
            if (! file_put_contents($path, $content)) {
                throw new \ErrorException('Failed to write to file: '.$path);
            }
        }
    }
}

if (! function_exists('concat_files')) {
    function concat_files($files)
    {
        if (! is_array($files)) {
            $files = func_get_args();
        }

        $combined = '';

        foreach ($files as $file) {
            $combined .= file_get_contents($file);
        }

        return $combined;
    }
}

if (! function_exists('concat_php_files')) {
    function concat_php_files($files)
    {
        if (! is_array($files)) {
            $files = func_get_args();
        }

        $combined = '';

        foreach ($files as $file) {
            $content = trim(file_get_contents($file));

            if (starts_with($content, '<?php'))
                $content = substr($content, 5);
            if (starts_with($content, '<?'))
                $content = substr($content, 2);
            if (ends_with($content, '?>'))
                $content = substr($content, 0, strlen($content) - 2);

            $combined .= $content;
        }

        return "<?php \n".$combined;
    }
}

if (! function_exists('buffer_output')) {
    function buffer_output()
    {
        $obLevel = ob_get_level();
        ob_start();
    }
}

if (! function_exists('discard_output')) {
    function discard_output()
    {
        ob_clean();
    }
}

if (! function_exists('save_output')) {
    function save_output()
    {
        return ltrim(ob_get_clean());
    }
}
