<?php
function sourdough_get_posts($type = 'post', $key = null, $value = null, $count = -1, $last = 2) {
    /*
    Custom queries to speed up CPT searches.
    */
    global $wpdb;

    if ($key == null && $value == null) {
        $querystr = "
            SELECT wposts.* 
            FROM $wpdb->posts wposts
            WHERE wposts.post_type = '{$type}' 
            AND wposts.post_status = 'publish' 
            ORDER BY wposts.post_date DESC
            LIMIT {$count}
            ";
    }
    else {
        $querystr = "
            SELECT wposts.* 
            FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
            WHERE wposts.ID = wpostmeta.post_id 
            AND wpostmeta.meta_key = '{$key}' 
            AND wpostmeta.meta_value = '{$value}' 
            AND wposts.post_type = '{$type}' 
            AND wposts.post_status = 'publish' 
            ORDER BY wposts.post_date DESC
            LIMIT {$count}
            ";
    }

    $result = $wpdb->get_results($querystr, OBJECT);
    return $result;
}

// Curl helper function
function curl_get($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    $return = curl_exec($curl);
    curl_close($curl);
    return $return;
}

function do_not_duplicate( $ID = false ) {
    /*
    Creates a cache of already displayed posts.
    Used to avoid duplicates.
    */
    $posts = wp_cache_get('do_not_duplicate', 'sourdough');

    if ( ! $posts ) {
        $posts = array();
    }

    // We're adding a new post.
    if ( $ID ) {
        $posts[] = $ID;
        wp_cache_set('do_not_duplicate', $posts, 'sourdough', 3600);
        return true;
    }
    // We're returning stored posts.
    else {
        return $posts;
    }
}

function plural( $num ) {
    /*
    Returns "s" unless $num is "1"
    Used by `relative_date`.
    */
    if ($num != 1)
        return "s";
}

function get_relative_date( $date ) {
    /*
    Returns relative(more human) date string.
    Uses: `plural`.

    Usage:
    `get_relative_date(get_the_date())`
    */
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

function the_relative_date( $fallback = 'F d, Y' ) {
    /*
    Return the post date in relative format.
    Uses: `get_relative_date()`

    Must be used within the loop.
    */
    if (function_exists('get_relative_date')) {
        echo get_relative_date(get_the_date());
    }
    else {
        echo get_the_date($fallback);
    }
}

function load_theme_widgets( $dir = 'widgets' ) {
    /*
    Load all .php files inside `widget` folder.

    Update 24/10/2010:
     Added statement to check child theme first,
     then fallback on Sourdough.
     
    Update 08/10/2010:
     Changed TEMPLATEPATH -> STYLESHEETPATH
     to make the path relative to any child theme.
    */
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