<!DOCTYPE html> 
<html <?php language_attributes(); ?>>

<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>"> 
 
    <title><?php wp_title( '&ndash;', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ); ?></title> 
 
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <?php wp_head(); ?> 

</head> 

<body <?php body_class(); ?>> 

<div id="wrapper">

    <a href="#content" id="to_content">Jump To Content</a>

    <div id="header" class="container clearfix">
        <div id="title" class="column third">
            <h1 id="logo"><a href="<?php bloginfo('home') ?>/" title="<?php echo wp_specialchars( get_bloginfo('name'), 1 ) ?>" rel="home" class="block"><?php echo wp_specialchars( get_bloginfo('name'), 1 ) ?></a></h1>

            <p id="description"><?php bloginfo('description') ?></p>
        </div>

        <div id="menu_1" class="menu column fifth">
            <?php wp_nav_menu(array( 'container' => '', 'theme_location' => 'menu_1', 'link_before' => '' )); ?>
        </div>

        <div id="menu_2" class="menu column fifth">
            <?php wp_nav_menu(array( 'container' => '', 'theme_location' => 'menu_2', 'link_before' => '' )); ?>
        </div>

        <div class="column fourth last">
        <?php if (!dynamic_sidebar( 'header-widget-area' )) : ?>
        <?php endif; ?>
        </div>
    </div>

    <div id="body" class="container clearfix">