<?php
/*
    Default post loop.
     Create page specific loops: `loop-<template name>.php`
*/
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