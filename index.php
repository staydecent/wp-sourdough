<?php get_header(); ?>

    <?php if (!dynamic_sidebar( 'home-widget-area' )) : ?>
    <?php endif; ?>

    <div id="content" class="column eight">
        <div id="posts" class="clearfix">
            <?php
            /*
                Default post loop.
            */
            $post_count = 1;
            while ( have_posts() ) {
                the_post();
                /*
                    Skip any posts already displayed as a feature.
                    TODO: something?!?!
                */
                if ( true ) {
                    /*
                        Include content file.
                    */
                    get_template_part( 'excerpt', 'index' );
                    ++$post_count;
                }
            }
            ?>
        </div>
        
        <?php if ( $wp_query->max_num_pages > 1 ) : ?>
        <div class="pagination clearfix">
            <span class="prev button"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'sourdough' ) ); ?></span>
            <span class="next button"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'sourdough' ) ); ?></span>
        </div>
        <?php endif; ?>
    </div>

    <?php get_sidebar() ?>

<?php get_footer(); ?>