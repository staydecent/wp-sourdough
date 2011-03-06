<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php wp_title( '&ndash;', true, 'right' ); echo esc_html( get_bloginfo('name'), 1 ); ?></title>

    <meta name="description" content="<?php bloginfo('description') ?>">
    <meta name="author" content="Staydecent">

    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>> 

    <header>
        <div class="inner">

            <h1><?php echo esc_html( get_bloginfo('name'), 1 ) ?></h1>

            <nav>
            <?php wp_nav_menu(array( 'container' => '', 'theme_location' => 'menu_1', 'link_before' => '' )); ?>
            </nav>

        </div>
    </header>

    <div id="body">
        <div class="inner">