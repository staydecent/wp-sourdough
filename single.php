<?php get_header(); ?>

    <div id="body" class="container"><div class="inner">

        <div class="posts col8">
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

    </div></div>

<?php get_footer(); ?>