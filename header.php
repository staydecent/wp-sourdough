<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="author" content="Adrian Unger">
    <meta name="description" content="<?php bloginfo('description') ?>">

    <title><?php wp_title( '&ndash;', true, 'right' ); echo esc_html( get_bloginfo('name'), 1 ); ?></title>

    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="<?php bloginfo('template_directory') ?>/assets/js/respond.min.js"></script>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>> 

<header role="banner" id="masthead">

    <h1><?php echo esc_html( get_bloginfo('name'), 1 ) ?></h1>

    <nav role="navigation" id="globalnav">
        <?php wp_nav_menu(array( 'container' => '', 'theme_location' => 'menu_1', 'link_before' => '' )); ?>
    </nav>

</header>

<div role="main" id="main">