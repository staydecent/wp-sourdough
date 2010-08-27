<?php get_header() ?>

	<div id="body">
		<div class="container">

		<div id="content" class="left">
		
		<?php if (have_posts()) : ?>

		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php /* If this is a category archive */ if (is_category()) { ?>
			<h2 class="title">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
		<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
			<h2 class="title">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
		<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<h2 class="title">Archive for <?php the_time('F jS, Y'); ?></h2>
		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h2 class="title">Archive for <?php the_time('F, Y'); ?></h2>
		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<h2 class="title">Archive for <?php the_time('Y'); ?></h2>
		<?php /* If this is an author archive */ } elseif (is_author()) { ?>
			<h2 class="title">Author Archive</h2>
		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<h2 class="title">Blog Archives</h2>
		<?php } ?>


		<div class="navigation clearfix">
			<div class="left"><?php next_posts_link('&larr; Older Entries') ?></div>
			<div class="right"><?php previous_posts_link('Newer Entries &rarr;') ?></div>
		</div>

		<?php while (have_posts()) : the_post(); ?>
		
			<div id="post-<?php the_ID() ?>" class="post">
				<h3 class="title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title() ?>" rel="bookmark"><?php the_title() ?></a></h3>
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

	<?php else :

		if ( is_category() ) { // If this is a category archive
			printf("<h2 class='center'>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h2 class='center'>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
		} else {
			echo("<h2 class='center'>No posts found.</h2>");
		}
		get_search_form();

	endif; ?>

		</div><!-- #content -->

<?php get_sidebar() ?>

		</div>
	</div>

<?php get_footer() ?>