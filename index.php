<?php 
    get_header();
?>

    <?php if (!dynamic_sidebar( 'home-widget-area' )) : ?>
    <?php endif; ?>

    <div id="content" class="column twelve">
        <div id="headlines" class="column eight">

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