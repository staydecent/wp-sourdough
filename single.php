<?php get_header(); ?>

    <div id="content" class="column eight">
        <h2>News</h2>
        <?php
        /*
            Single post loop.
        */
        while ( have_posts() ) {
            the_post();
            /*
                Include content file.
            */
            get_template_part( 'content', 'single' );

            comments_template( '', true );
        }
        ?>
    </div>

    <?php get_sidebar() ?>

<?php get_footer() ?>