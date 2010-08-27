<?php get_header() ?>

	<div id="body">
		<div class="container">

		<div id="content" class="left">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle">Search Results</h2>

		<div class="navigation">
			<div class="left"><?php next_posts_link('&larr; Older Entries') ?></div>
			<div class="right"><?php previous_posts_link('Newer Entries &rarr;') ?></div>
		</div>


		<?php while (have_posts()) : the_post(); ?>

			<div <?php post_class() ?>>
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
				<small><?php the_time('l, F jS, Y') ?></small>

				<p class="postmetadata"><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
			</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="left"><?php next_posts_link('&larr; Older Entries') ?></div>
			<div class="right"><?php previous_posts_link('Newer Entries &rarr;') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">No posts found. Try a different search?</h2>
		<?php get_search_form(); ?>

	<?php endif; ?>

		</div><!-- #content -->

<?php get_sidebar() ?>

		</div>
	</div>

<?php get_footer() ?>