<?php
/*
    I tried not to create too much of a new 
    folder structure from what themers are used to.
    So I broke up my functions as follows:

    - Generic UDF's (lib/utilities.php)
    - Theme Helpers (lib/helpers.php)
    - Theme options & Filters (this file)

    Here I'll load the utilities and helpers files.
*/
$sourdough_utilities = './lib/utilities.php';
if (is_file($sourdough_utilities)) {
    require $sourdough_utilities;
}
$sourdough_helpers = './lib/helpers.php';
if (is_file($sourdough_helpers)) {
    require $sourdough_helpers;
}
/*
    Here we add our own setup function, to encapsulate
    all of our theme support options and filters.

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
        Theme Support & Filters
        Serves as a toc of sorts.
    */
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_custom_background();
    add_filter('wp_trim_excerpt', 'sourdough_excerpt_more');
    add_filter('excerpt_more', 'sourdough_excerpt_ellipsis');
    add_filter('body_class', 'sourdough_parent_class');
    add_filter('get_search_form', 'sourdough_search_form');
    /*
        Enable custom menus
    */
    register_nav_menus(array(
        'primary' => __( 'Primary Navigation', 'wpp' ),
    ));
    /*
        Custom header settings

        You should change the WIDTH and HEIGHT based
        on your theme you are developing.
    */
    define( 'HEADER_TEXTCOLOR', '' );
    define( 'NO_HEADER_TEXT', true );
    define( 'HEADER_IMAGE', '%s/img/headers/default.jpg' );
    define( 'HEADER_IMAGE_WIDTH', apply_filters( 'sourdough_header_image_width', 940 ) );
    define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'sourdough_header_image_height', 320 ) );

    add_custom_image_header( '','sourdough_admin_header_style' );

    register_default_headers( array(
        'default' => array(
            'url'           => '%s/img/headers/default.jpg',
            'thumbnail_url' => '%s/img/headers/default-thumb.jpg',
            'description'   => __( 'Default', 'sourdough' )
        )
    ));
    /*
        Post thumbnail settings
        
        There are some suggested sizes registered
        below. But, it is suggested that you define
        any thumbnail dimensions you need for your
        theme.
    */
    set_post_thumbnail_size(200, 140, true); // Normal post thumbnails (loop)
    add_image_size('header-image', HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true); // Permalink thumbnail size
    add_image_size('fullpost-image', 620, 380, true); // widget thumbnail size
    add_image_size('widget-thumbnail', 50, 50, true); // widget thumbnail size
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

/*
    Removes the ellipsis from auto-generated
    exceprts.
*/
if (!function_exists( 'sourdough_excerpt_ellipsis' )) :
function sourdough_excerpt_ellipsis( $more ) {
    return '';
}
endif;

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

/*
    Return a custom search form.
    No need for a searchform.php
*/
if (!function_exists('sourdough_search_form')) :
function sourdough_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" action="' . trailingslashit(get_bloginfo('url')) . '">';
    $form .= '<div class="clearfix">';
    $form .= '<input type="text" name="s" id="s" class="left" placeholder="Search" value="' . get_search_query() . '" />';
    $form .= '<input type="submit" name="searchsubmit" id="searchsubmit" class="left" value="" />';
    $form .= '</div>';
    $form .= '</form>'; 

    return $form;
}
endif;

// Widgetized Areas
if (function_exists('register_sidebar')) {
/* Test performance vs widgets_init hook */
    register_sidebar( array(
        'name'          => __( 'Primary Widget Area', 'wpp' ),
        'id'            => 'primary-widget-area',
        'description'   => __( 'The primary widget area', 'wpp' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    register_sidebar( array(
        'name'          => __( 'Secondary Widget Area', 'wpp' ),
        'id'            => 'secondary-widget-area',
        'description'   => __( 'The secondary widget area', 'wpp' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    register_sidebar( array(
        'name'          => __( 'Footer Widget Area', 'wpp' ),
        'id'            => 'footer-widget-area',
        'description'   => __( 'The footer widget area', 'wpp' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}

?>