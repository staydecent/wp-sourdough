<!DOCTYPE html> 
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" /> 
	<meta name="robots" content="noindex, nofollow" /> 
 
    <title>
    	<?php wp_title( '&ndash;', true, 'right' ); 
    	echo wp_specialchars( get_bloginfo('name'), 1 ); ?>
    </title> 
 
    <link rel="favourites icon" href="<?php bloginfo('template_url') ?>/img/favicon.ico" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <?php wp_head(); ?> 
</head> 
<body <?php body_class(); ?>> 

<div id="wrapper">

    <div id="header" class="container_12 clearfix">
        <a href="#content" id="to_content">Jump To Content</a>

        <div id="title" class="grid_5 alpha">
            <h1 id="logo"><a href="<?php bloginfo('home') ?>/" title="<?php echo wp_specialchars( get_bloginfo('name'), 1 ) ?>" rel="home" class="block"><?php echo wp_specialchars( get_bloginfo('name'), 1 ) ?></a></h1>

            <p id="description"><?php bloginfo('description') ?></p>
        </div>

        <div id="menu" class="grid_3">
            <?php wp_nav_menu(array( 'container' => '', 'theme_location' => 'primary', 'link_before' => '&rarr;' )); ?>
        </div>

        <div id="download" class="grid_4 omega">
            
        </div>
    </div>

    <div id="body" class="container_12 clearfix">