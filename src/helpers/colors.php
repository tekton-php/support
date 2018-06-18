<?php

if (! function_exists('is_bright')) {
    function is_bright($color)
    {
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
}

if (! function_exists('is_dark')) {
    function is_dark($color)
    {
        return ! is_bright($color);
    }
}
