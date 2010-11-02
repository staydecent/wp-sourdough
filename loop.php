<?php
/*
    Default post loop.
     Create page specific loops: `loop-<template name>.php`
*/
query_posts('posts_per_page=6'); # - any featured posts
while ( have_posts() ) {
    the_post();
    /*
        Skip any posts already displayed as a feature.
    */
    if ( ! in_array(get_the_ID(), do_not_duplicate()) ) {
        /*
            See: lib/helpers.php -> sourdough_headline()
        */
        sourdough_excerpt( '', 'excerpt-compact' );
    }
}

/*
    See: lib/helpers.php -> sourdough_pagination()
*/
sourdough_pagination();
?>