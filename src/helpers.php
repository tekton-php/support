<?php

function str_make_links($text) {
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

    // Check if there is a url in the text
    if (preg_match($reg_exUrl, $text, $url)) {
        // make the urls hyper links
        return preg_replace($reg_exUrl, '<a href="'.$url[0].'" rel="nofollow">'.$url[0].'</a>', $text);
    }
    else {
        return $text;
    }
}

function is_assoc(array $arr)
{
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function build_url(array $parts) {
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

function is_iterable($var) {
    return (is_array($var) || $var instanceof Traversable || $var instanceof stdClass);
}

function parse_attributes($attr = array()) {
    if ( ! is_array($attr)) {
        return '';
    }

    return join(' ', array_map(function($key) use ($attr) {
       if (is_bool($attr[$key])) {
          return $attr[$key] ? $key : '';
       }

       if (is_array($attr[$key])) {
           return $key.'="'.implode(' ', $attr[$key]).'"';
       }
       else {
           return $key.'="'.$attr[$key].'"';
       }
    }, array_keys($attr)));
}

function is_bright($color){
    $r = hexdec(substr($color,0,2));
    $g = hexdec(substr($color,2,2));
    $b = hexdec(substr($color,4,2));

    $contrast = sqrt(
        $r * $r * .241 +
        $g * $g * .691 +
        $b * $b * .068
    );

    if ($contrast > 130){
        return true;
    }
    else{
        return false;
    }
}

function is_dark($color) {
    return ! is_bright($color);
}

function make_datetime($date_str, $format = null) {
    if (is_null($format) && defined('DATE_FORMAT')) {
        $format = DATE_FORMAT;
    }

    return \DateTime::createFromFormat($format, $date_str);
}

function format_date($date, $format = null) {
    if (is_null($format) && defined('DATE_FORMAT')) {
        $format = DATE_FORMAT;
    }

    if ($date instanceof \DateTime) {
        return $date->format($format);
    }

    return $date;
}

function validateDate($date, $format = null) {
    if (is_null($format) && defined('DATE_FORMAT')) {
        $format = DATE_FORMAT;
    }

    $d = \DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}


function user_ip() {
    return app('request')->ip();
}
