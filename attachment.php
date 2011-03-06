<?php get_header(); ?>

    <?php if (!dynamic_sidebar( 'home-widget-area' )) : ?>
    <?php endif; ?>

    <div id="content" class="column eight">
        <?php
        /*
            Default post loop.
        */
        while ( have_posts() ) {
            the_post();
            ?>
            <h2 class="page-title"><a href="<?php echo get_permalink($post->post_parent) ?>" title="Return to <?php wp_specialchars( get_the_title($post->post_parent), 1 ) ?>" rel="attachment"><?php echo get_the_title($post->post_parent) ?></a></h2>

            <div id="post-<?php the_ID() ?>" class="post">
                <h3 class="title"><?php the_title() ?></h3>
                
                <div class="content">
                    <a href="<?php echo wp_get_attachment_url($post->ID) ?>" title="<?php echo wp_specialchars( get_the_title($post->ID), 1 ) ?>" rel="attachment"><?php echo basename($post->guid) ?></a>
                    <p><?php if ( !empty($post->post_excerpt) ) the_excerpt() ?></p>
                    <?php the_content() ?>
                </div>
            </div>
            <?php
        }
        ?>

        <?php if ( $wp_query->max_num_pages > 1 ) : ?>
        <div class="pagination clearfix">
            <span class="prev button"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'sourdough' ) ); ?></span>
            <span class="next button"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'sourdough' ) ); ?></span>
        </div>
        <?php endif; ?>
    </div>

    <?php get_sidebar() ?>

<?php get_footer(); ?>