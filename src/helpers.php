<?php

// Create a DS shorthand for the system directory separator
if (! defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
// Include illuminate helpers
if (! defined('TEKTON_ILLUMINATE'))
    define('TEKTON_ILLUMINATE', true);

/* ------------------------------------ */

require_once __DIR__.DS.'helpers'.DS.'arrays.php';
require_once __DIR__.DS.'helpers'.DS.'cache.php';
require_once __DIR__.DS.'helpers'.DS.'colors.php';
require_once __DIR__.DS.'helpers'.DS.'dates.php';
require_once __DIR__.DS.'helpers'.DS.'files.php';
require_once __DIR__.DS.'helpers'.DS.'html.php';
require_once __DIR__.DS.'helpers'.DS.'other.php';

/* ------------------------------------ */

if (TEKTON_ILLUMINATE) {
    require_once __DIR__.DS.'helpers'.DS.'illuminate.php';
}
