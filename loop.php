<?php
/*
    Default post loop.
     Create page specific loops: `loop-<template name>.php`
*/
query_posts( array('post__not_in' => $do_not_duplicate, 'posts_per_page' => '10') );
while ( have_posts() ) {
    the_post();
    /*
        See: lib/helpers.php -> sourdough_headline()
    */
    sourdough_excerpt( '', 'excerpt-compact' );
}

/*
    See: lib/helpers.php -> sourdough_pagination()
*/
sourdough_pagination();
?>