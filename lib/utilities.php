<?php 
/*
    Sourdough Utilities

    01 - plural
    02 - get_relative_date
    03 - the_relative_date
*/

/*
    Creates a cache of already displayed posts.
    Used to avoid duplicates.
*/
function do_not_duplicate( $ID = false ) {
    $posts = wp_cache_get('do_not_duplicate', 'sourdough');

    if ( ! $posts ) {
        $posts = array();
    }

    # We're adding a new post.
    if ( $ID ) {
        $posts[] = $ID;
        wp_cache_set('do_not_duplicate', $posts, 'sourdough', 3600);
        return true;
    }
    # We're returning stored posts.
    else {
        return $posts;
    }
}

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
    return date("F j, Y", strtotime($date));
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

    Update 24/10/2010:
     Added statement to check child theme first,
     then fallback on Sourdough.
     
    Update 08/10/2010:
     Changed TEMPLATEPATH -> STYLESHEETPATH
     to make the path relative to any child theme.
*/
function load_theme_widgets( $dir = 'widgets' ) {
    $files = wp_cache_get('load_theme_widgets', 'sourdough');

    if ( $files ) {
        foreach ($files as $f) {
            include $f;
        }
    }

    $files = array();

    if ( $dh = @opendir(STYLESHEETPATH.'/'.$dir) ) {
        while ( false !== ($file = readdir($dh)) ) {
            if ( is_file(STYLESHEETPATH.'/'.$dir.'/'.$file) && strtolower(substr($file, -4, 4)) == ".php" ) {
                $files[] = STYLESHEETPATH.'/'.$dir.'/'.$file;
            }
        }
        closedir($dh);
    }
    elseif ( $dh = @opendir(TEMPLATEPATH.'/'.$dir) ) {
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