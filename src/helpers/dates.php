<?php

// ISO standard date formats
if (! defined('DATE_ISO'))
    define('DATE_ISO', 'Y-m-d');
if (! defined('DATETIME_ISO'))
    define('DATETIME_ISO', 'Y-m-d H:i:s');

/* ------------------------------------ */

if (! function_exists('make_datetime')) {
    function make_datetime($date_str, $format = null)
    {
        if (is_null($format) && defined('DATE_FORMAT')) {
            $format = DATE_FORMAT;
        }

        return \DateTime::createFromFormat($format, $date_str);
    }
}

if (! function_exists('format_date')) {
    function format_date($date, $format = null)
    {
        if (is_null($format) && defined('DATE_FORMAT')) {
            $format = DATE_FORMAT;
        }

        if ($date instanceof \DateTime) {
            return $date->format($format);
        }

        return $date;
    }
}

if (! function_exists('validate_date')) {
    function validate_date($date, $format = null)
    {
        if (is_null($format) && defined('DATE_FORMAT')) {
            $format = DATE_FORMAT;
        }

        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}
