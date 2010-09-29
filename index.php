<?php 
    get_header();
?>

    <?php if (!dynamic_sidebar( 'home-widget-area' )) : ?>
    <?php endif; ?>

    <div id="content" class="column one">
        <div id="headlines">

        <?php 
        /*
            Load the loop to output posts.
        */
        get_template_part( 'loop', 'index' );
        ?>

    	</div>

        <?php get_sidebar() ?>

    </div><!-- #content -->

<?php 
    get_footer();
?>