<?php 
/*
    Sourdough Utilities

    01 - plural
    02 - get_relative_date
    03 - the_relative_date
*/

/*
    Returns "s" unless $num is "1"
    Used by `relative_date`.
*/
function plural( $num ) {
    if ($num != 1)
        return "s";
}

/*
    Returns relative(more human) date string.
    Uses: `plural`.

    Usage:
    `get_relative_date(get_the_date())`
*/
function get_relative_date( $date ) {
    $diff = time() - strtotime($date);
    if ($diff < 60)
        return $diff." second".plural($diff)." ago";
    $diff = round($diff / 60);
    if ($diff < 60)
        return $diff." minute".plural($diff)." ago";
    $diff = round($diff / 60);
    if ($diff < 24)
        return $diff." hour".plural($diff)." ago";
    $diff = round($diff / 24);
    if ($diff < 7)
        return $diff." day".plural($diff)." ago";
    $diff = round($diff / 7);
    if ($diff < 4)
        return $diff." week".plural($diff)." ago";
    return "on ".date("F j, Y", strtotime($date));
}

/*
    Return the post date in relative format.
    Uses: `get_relative_date()`

    Must be used within the loop.
*/
function the_relative_date( $fallback = 'F d, Y' ) {
    if (function_exists('get_relative_date')) {
        echo get_relative_date(get_the_date());
    }
    else {
        echo get_the_date($fallback);
    }
}

/*
    Load all .php files inside `widget` folder.
*/
function load_theme_widgets( $dir = 'widgets' ) {
    $files = wp_cache_get('load_theme_widgets', 'sourdough');

    if ( $files ) {
        foreach ($files as $f) {
            include $f;
        }
    }

    $files = array();

    if ( $dh = opendir(TEMPLATEPATH.'/'.$dir) ) {
        while ( false !== ($file = readdir($dh)) ) {
            if ( is_file(TEMPLATEPATH.'/'.$dir.'/'.$file) && strtolower(substr($file, -4, 4)) == ".php" ) {
                $files[] = TEMPLATEPATH.'/'.$dir.'/'.$file;
            }
        }
        closedir($dh);
    }
    
    wp_cache_set('load_theme_widgets', $files, 'sourdough', 3600);

    foreach ($files as $f) {
        include $f;
    }
}
?>