<?php 
    get_header();
?>

    <div id="content" class="column twelve">
        <div id="single" class="column eight">

        <?php
        /*
            Load the loop to output posts.
        */
        get_template_part( 'loop', 'single' );
        ?>

        </div>

        <?php get_sidebar() ?>

    </div><!-- #content -->

<?php get_footer() ?>