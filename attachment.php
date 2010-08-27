<?php get_header() ?>

	<div id="container">
		<div id="content">

<?php the_post() ?>

			<h2 class="page-title"><a href="<?php echo get_permalink($post->post_parent) ?>" title="Return to <?php wp_specialchars( get_the_title($post->post_parent), 1 ) ?>" rel="attachment"><?php echo get_the_title($post->post_parent) ?></a></h2>

			<div id="post-<?php the_ID() ?>" class="post">
				<h3 class="title"><?php the_title() ?></h3>
				<div class="content">
					<a href="<?php echo wp_get_attachment_url($post->ID) ?>" title="<?php echo wp_specialchars( get_the_title($post->ID), 1 ) ?>" rel="attachment"><?php echo basename($post->guid) ?></a>
					<p><?php if ( !empty($post->post_excerpt) ) the_excerpt() ?></p>
					<?php the_content() ?>
				</div>
			</div>
			
		</div>

<?php get_sidebar() ?>

		</div>
	</div>

<?php get_footer() ?>