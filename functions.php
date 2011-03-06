<?php

/*
Theme functions and content types.
Based on Sourdough (0.1.5) by Adrian Unger.

## Table of Contents
 01 - Load libraries & content types
 02 - Setup theme options
 03 - Content filters
*/

/*
    01 - Load libraries & content types
*/
require TEMPLATEPATH.'/lib/utilities.php';
require TEMPLATEPATH.'/lib/helpers.php';
require TEMPLATEPATH.'/lib/widgets.php';

$content_types = array(
    ''
);
foreach ($content_types as $type) {
    $file = TEMPLATEPATH.'/lib/content_types/'.$type.'.php';
    if (is_file($file)) {
        include $file; 
    }
}

/*
    02 - Setup theme options
*/
add_action('after_setup_theme', 'sourdough_setup');

if (!function_exists( 'sourdough_setup')) {
    function sourdough_setup() {
        // Theme support
        add_theme_support('post-thumbnails');
        add_theme_support('automatic-feed-links');
        add_custom_background();
        load_theme_widgets();
        // Enable custom menus
        register_nav_menus(array(
            'menu_1' => __( 'Menu 1', 'sourdough' ),
            'menu_2' => __( 'Menu 2', 'sourdough' ),
        ));
        /*
        Post thumbnail settings
        
        There are some predefined sizes registered
        below. But, it is suggested that you define
        any thumbnail dimensions you need for your
        theme.
        */
        set_post_thumbnail_size(252, 252, true); // Normal post thumbnails (loop)
        add_image_size('post-image', 745);
        add_image_size('medium-thumbnail', 170, 170, true);
        add_image_size('small-thumbnail', 50, 50, true);
    }
}

add_action('init', 'sourdough_init');

function sourdough_init() {
    // site specific stuff
    wp_enqueue_script('sourdough', get_bloginfo('stylesheet_directory').'/assets/js/site.js', array('jquery'), '1.0');
}

add_action('admin_init', 'admin_init');

function admin_init() {
    // enhance admin meta boxes
}

/*
    03 - Content filters
*/
if (!function_exists( 'sourdough_admin_header_style')) {
    function sourdough_admin_header_style() {
    // Styles the header display within the admin panel
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
}

if (!function_exists( 'sourdough_excerpt_more')) {
    function sourdough_excerpt_more( $post_excerpt ) {
        /*
        Adds a 'continue reading' link to the end
        of *all* excerpts! (auto, more and custom)
        */
        return $post_excerpt.'<br><a href="'.get_permalink().'" class="more">'. __( 'Read More', 'sourdough' ).'</a>';
    }
}
add_filter('wp_trim_excerpt', 'sourdough_excerpt_more');

if (!function_exists( 'sourdough_excerpt_ellipsis')) {
    function sourdough_excerpt_ellipsis( $more ) {
        /*
        Removes the ellipsis from auto-generated
        exceprts.
        */
        return '&hellip;';
    }
}
add_filter('excerpt_more', 'sourdough_excerpt_ellipsis');

if (!function_exists( 'sourdough_excerpt_length')) {
    function sourdough_excerpt_length( $length ) {
        /*
        Set the output length for excerpts.
        */
        return 20;
    }
}
add_filter( 'excerpt_length', 'sourdough_excerpt_length' );

if (!function_exists('sourdough_search_form')) {
    function sourdough_search_form( $form ) {
        /*
        Return a custom search form.
        No need for a searchform.php
        */
        $form = '<form role="search" method="get" id="searchform" action="' . trailingslashit(get_bloginfo('url')) . '">';
        $form .= '<div class="clearfix">';
        $form .= '<input type="text" name="s" id="s" class="left" placeholder="Search" value="' . get_search_query() . '" />';
        $form .= '<input type="submit" name="searchsubmit" id="searchsubmit" class="left" value="&rarr;" />';
        $form .= '</div>';
        $form .= '</form>'; 

        return $form;
    }
}
add_filter('get_search_form', 'sourdough_search_form');

if (!function_exists('sourdough_comment')) {
    function sourdough_comment( $comment, $args, $depth ) {
        /*
        Comment template
        */
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case '' :
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <div id="comment-<?php comment_ID(); ?>">
            <div class="comment-author vcard">
                <?php echo get_avatar( $comment, 125 ); ?>
                <?php printf( __( '%s', 'sourdough' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
            </div><!-- .comment-author .vcard -->
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <em><?php _e( 'Your comment is awaiting moderation.', 'sourdough' ); ?></em>
                <br />
            <?php endif; ?>

            <div class="comment-meta commentmetadata">
                <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php the_relative_date();  ?></a>

                <?php edit_comment_link( __( '(Edit)', 'sourdough' ), ' ' ); ?>
            </div><!-- .comment-meta .commentmetadata -->

            <div class="comment-body"><?php comment_text(); ?></div>

            <div class="reply">
                <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div><!-- .reply -->
        </div><!-- #comment-##  -->

        <?php
                break;
            case 'pingback'  :
            case 'trackback' :
        ?>
        <li class="post pingback">
            <p><?php _e( 'Pingback:', 'sourdough' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'sourdough'), ' ' ); ?></p>
        <?php
                break;
        endswitch;
    }
}

?>