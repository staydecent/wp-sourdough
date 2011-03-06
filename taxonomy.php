<?php get_header(); ?>

    <div id="content" class="column eight">
        <?php
        $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

        if ($term->taxonomy == 'location') {
            echo '<h2 class="title">Shows in '.$term->name.'</h2>';
        }
        if ($term->taxonomy == 'venue') {
            echo '<h2 class="title">Shows at '.$term->name.'</h2>';
        }

        /*
            Archive post loop.
        */
        $post_count = 1;
        while ( have_posts() ) {
            the_post();
            /*
                Include content file.
            */
            ++$post_count;
            $meta = get_post_custom($post->ID);
            ?>
            <div id="post-<?php the_ID() ?>" class="artist">

                <h3 class="title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title() ?>" rel="bookmark"><?php echo $meta['show_meta_artist'][0] ?></a></h3>

                <div class="column five">
                    <strong><a href="<?php echo get_permalink($show->ID) ?>">+ <?php echo date('F d, Y', strtotime($meta['datetime'][0])); ?></a></strong>
                </div>
                <div class="column three"><?php the_terms($show->ID, 'location', '', ', ', ' '); ?></div>
                <div class="column four last"><?php the_terms($show->ID, 'venue', '', ', ', ' '); ?></div>

            </div>
            <?php
        }
        ?>
    </div>

    <?php get_sidebar() ?>

<?php get_footer() ?>