<?php get_header() ?>

	<div id="body">
		<div class="container">

		<div id="content" class="left">
		
		<?php while ( have_posts() ) : the_post() ?>

			<div id="post-<?php the_ID() ?>" class="post">
				<h2 class="title"><?php the_title() ?></h2>
				<abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time('Y-m-d\TH:i:sO') ?></abbr>
				<div class="content">
					<?php the_content( __( 'Read More &raquo;' ) ) ?>
					<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				</div>

				<div class="meta">
					<span class="categories">Filed under: <?php the_category(', ') ?></span>
					<span class="tags"><?php the_tags('Tagged with: ', ', ', '<br />') ?></span>
				</div>
			</div>

		<?php endwhile; ?>

			<div class="navigation clearfix">
				<div class="left"><?php next_posts_link('&larr; Older Entries') ?></div>
				<div class="right"><?php previous_posts_link('Newer Entries &rarr;') ?></div>
			</div>

		<?php comments_template(); ?>

		</div><!-- #content -->

<?php get_sidebar() ?>

		</div>
	</div>

<?php get_footer() ?>