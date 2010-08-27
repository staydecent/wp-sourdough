<?php get_header() ?>

		<div id="content" class="grid_8 alpha">
		
		<?php while ( have_posts() ) : the_post() ?>

			<div id="post-<?php the_ID() ?>" class="post">
				<h2 class="title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title() ?>" rel="bookmark"><?php the_title() ?></a></h2>
				<abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time('Y-m-d\TH:i:sO') ?></abbr>
				<div class="content"><?php the_content( __( 'Read More &raquo;' ) ) ?></div>

				<div class="meta">
					<span class="categories">Filed under: <?php the_category(', ') ?></span>
					<span class="tags"><?php the_tags('Tagged with: ', ', ', '<br />') ?></span>
					<span class="comments"><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></span>
				</div>
			</div>

		<?php endwhile; ?>

			<div class="navigation clearfix">
				<div class="left"><?php next_posts_link('&larr; Older Entries') ?></div>
				<div class="right"><?php previous_posts_link('Newer Entries &rarr;') ?></div>
			</div>

		</div><!-- #content -->

<?php get_sidebar() ?>
<?php get_footer() ?>