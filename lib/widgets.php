<?php

if (!function_exists('sourdough_widgets_init')) {
    function sourdough_widgets_init() {
        register_sidebar( array(
            'name'          => __( 'Header Widget Area', 'sourdough' ),
            'id'            => 'header-widget-area',
            'description'   => __( 'Widgets displayed in the header.', 'sourdough' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
        register_sidebar( array(
            'name'          => __( 'Homepage Widget Area', 'sourdough' ),
            'id'            => 'home-widget-area',
            'description'   => __( 'Widgets are spanning full-width before the posts loop.', 'sourdough' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
        register_sidebar( array(
            'name'          => __( 'Footer Widget Area', 'sourdough' ),
            'id'            => 'footer-widget-area',
            'description'   => __( 'Widgets are spanning full-width before the footer.', 'sourdough' ),
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
}
add_action( 'widgets_init', 'sourdough_widgets_init' );

?>