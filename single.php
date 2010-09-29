<?php 
    get_header();
    //sourdough_before_content();
?>

    <div id="content" class="column one">
        <div id="single">

        <?php
        while ( have_posts() ) {
        	the_post();
        	/*
        		See: lib/helpers.php -> sourdough_content()
        	*/
        	sourdough_content();
        
            comments_template( '', true );
        }
        /*
        	See: lib/helpers.php -> sourdough_pagination()
        */
        sourdough_pagination();
        ?>

        </div>

        <?php get_sidebar() ?>

    </div><!-- #content -->

<?php get_footer() ?>