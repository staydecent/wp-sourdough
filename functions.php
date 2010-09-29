<?php
/*
    I tried not to create too much of a new 
    folder structure from what themers are used to.
    So I broke up my functions as follows:

    - Generic UDF's (lib/utilities.php)
    - Theme Helpers (lib/helpers.php)
    - Theme support & Filters (this file)

    Here I'll load the utilities and helpers files.
*/
require '/lib/utilities.php';
require '/lib/helpers.php';
/*
    Here we add our own setup function, to encapsulate
    all of our theme support.

    Wrapped in an `if`, so, if desired, one can override it
    in a child theme.
*/
add_action( 'after_setup_theme', 'sourdough_setup' );

if (!function_exists( 'sourdough_setup' )) :
/* 
    Sets up theme options and features 
*/
function sourdough_setup() {
    /*
        Theme Support
    */
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_custom_background();
    load_theme_widgets();
    /*
        Enable custom menus
    */
    register_nav_menus(array(
        'menu_1' => __( 'Menu 1', 'sourdough' ),
        'menu_2' => __( 'Menu 2', 'sourdough' ),
        'menu_3' => __( 'Menu 3', 'sourdough' ),
    ));
    /*
        Post thumbnail settings
        
        There are some predefined sizes registered
        below. But, it is suggested that you define
        any thumbnail dimensions you need for your
        theme.
    */
    set_post_thumbnail_size(300, 200, true); // Normal post thumbnails (loop)
    add_image_size('header-image', 960, 300, true); // Permalink thumbnail size
    add_image_size('post-image', 620, 420, true); // widget thumbnail size
    add_image_size('square-thumbnail', 50, 50, true); // square thumbnail size
}
endif;

if (!function_exists( 'sourdough_admin_header_style' )) :
/* 
    Styles the header display within the admin panel
*/
function sourdough_admin_header_style() {
?>
<style type="text/css">
#headimg {
    border:1px solid #000;
    border-width:1px 0;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
    #headimg #name { }
    #headimg #desc { }
*/
</style>
<?php
}
endif;

/*
    Adds a 'continue reading' link to the end
    of *all* excerpts! (auto, more and custom)
*/
if (!function_exists( 'sourdough_excerpt_more' )) :
function sourdough_excerpt_more( $post_excerpt ) {
    return $post_excerpt.' <a href="'.get_permalink($post->ID).'" class="more">'. __( 'Read More &raquo;', 'sourdough' ).'</a>';
}
endif;
add_filter('wp_trim_excerpt', 'sourdough_excerpt_more');

/*
    Removes the ellipsis from auto-generated
    exceprts.
*/
if (!function_exists( 'sourdough_excerpt_ellipsis' )) :
function sourdough_excerpt_ellipsis( $more ) {
    return '&hellip;';
}
endif;
add_filter('excerpt_more', 'sourdough_excerpt_ellipsis');

/*
    Set the output length for excerpts.
*/
if (!function_exists( 'sourdough_excerpt_length' )) :
function sourdough_excerpt_length( $length ) {
    return 55;
}
endif;
add_filter( 'excerpt_length', 'sourdough_excerpt_length' );

/*
    Custom Body Class
    Return the parent class in all cases.
*/
if (!function_exists( 'sourdough_parent_class' )) :
function sourdough_parent_class( $classes ) {
    // $classes[2] should return: category-<cat_name> 
    $cat_slug = explode('-', $classes[2], 2);
    $cat = get_category_by_slug($cat_slug[1]);
    $parent = get_category( $cat->parent );
    
    if(!$parent->errors) {
        $classes[] = $parent->slug;
    } else {
        $classes[] = $cat->slug;
    }

    return $classes;
}
endif;
add_filter('body_class', 'sourdough_parent_class');

/*
    Return a custom search form.
    No need for a searchform.php
*/
if (!function_exists('sourdough_search_form')) :
function sourdough_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" action="' . trailingslashit(get_bloginfo('url')) . '">';
    $form .= '<div class="clearfix">';
    $form .= '<input type="text" name="s" id="s" class="left" placeholder="Search" value="' . get_search_query() . '" />';
    $form .= '<input type="submit" name="searchsubmit" id="searchsubmit" class="left" value="&rarr;" />';
    $form .= '</div>';
    $form .= '</form>'; 

    return $form;
}
endif;
add_filter('get_search_form', 'sourdough_search_form');

/*
    Make EVERYTHING more flexible and dynamic.
*/
if (function_exists('register_sidebar')) {
/* Test performance vs widgets_init hook */
    register_sidebar( array(
        'name'          => __( 'Header Widget Area', 'sourdough' ),
        'id'            => 'header-widget-area',
        'description'   => __( 'Widget displayed in the header.', 'sourdough' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    register_sidebar( array(
        'name'          => __( 'Homepage Widget Area', 'sourdough' ),
        'id'            => 'home-widget-area',
        'description'   => __( 'Widget are spanning full-width before the posts loop.', 'sourdough' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    register_sidebar( array(
        'name'          => __( 'Homepage Sidebar', 'sourdough' ),
        'id'            => 'home-sidebar',
        'description'   => __( 'The sidebar displayed on the homepage.', 'sourdough' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    register_sidebar( array(
        'name'          => __( 'Single page Sidebar', 'sourdough' ),
        'id'            => 'single-sidebar',
        'description'   => __( 'The sidebar displayed on single posts.', 'sourdough' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    register_sidebar( array(
        'name'          => __( 'Common Sidebar', 'sourdough' ),
        'id'            => 'common-sidebar',
        'description'   => __( 'The common sidebar.', 'sourdough' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}

?>