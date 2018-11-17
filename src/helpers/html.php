<?php

if (! function_exists('add_ids_to_headings')) {
    function add_ids_to_headings($content)
    {
        $pattern = '#(?P<full_tag><(?P<tag_name>h\d)(?P<tag_extra>[^>]*)>(?P<tag_contents>[^<]*)</h\d>)#i';

        if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
            $find = [];
            $replace = [];

            foreach ($matches as $match) {
                if (strlen($match['tag_extra']) && false !== stripos($match['tag_extra'], 'id=')) {
                    continue;
                }

                $find[]    = $match['full_tag'];
                $id        = sanitize_title($match['tag_contents']);
                $id_attr   = sprintf(' id="%s"', $id);
                $replace[] = sprintf('<%1$s%2$s%3$s>%4$s</%1$s>', $match['tag_name'], $match['tag_extra'], $id_attr, $match['tag_contents']);
            }

            $content = str_replace($find, $replace, $content);
        }

        return $content;
    }
}

if (! function_exists('str_make_links')) {
    function str_make_links($text)
    {
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
}

if (! function_exists('parse_attributes')) {
    function parse_attributes($attr = array())
    {
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
}
