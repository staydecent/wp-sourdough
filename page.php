<?php get_header() ?>

	<div id="content" class="column eight">
    <?php while ( have_posts() ) : the_post() ?>

        <div id="post-<?php the_ID() ?>" class="post">
            <h2 class="title"><?php the_title() ?></h2>

            <div class="content">
                <?php the_content( __( 'Read More &raquo;' ) ) ?>
                <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
            </div>
        </div>

    <?php endwhile; ?>
	</div>

    <?php get_sidebar() ?>

<?php get_footer() ?>