<?php 
    get_header();
    //sourdough_before_content();
?>

	<div id="content" class="column twelve">
        <div id="archive" class="column eight">
		
		<?php if (have_posts()) : ?>

		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php /* If this is a category archive */ if (is_category()) { ?>
			<h2 class="page-title">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
		<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
			<h2 class="page-title">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
		<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<h2 class="page-title">Archive for <?php the_time('F jS, Y'); ?></h2>
		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h2 class="page-title">Archive for <?php the_time('F, Y'); ?></h2>
		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<h2 class="page-title">Archive for <?php the_time('Y'); ?></h2>
		<?php /* If this is an author archive */ } elseif (is_author()) { ?>
			<h2 class="page-title">Author Archive</h2>
		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<h2 class="page-title">Blog Archives</h2>
		<?php } ?>

		<?php 
        while (have_posts()) {
            the_post();
            /*
                See: lib/helpers.php -> sourdough_headline()
            */
            sourdough_excerpt( '', 'excerpt-compact' );
            /*
                See: lib/helpers.php -> sourdough_pagination()
            */
            sourdough_pagination();
        }
        ?>

        <?php else :

        if ( is_category() ) { // If this is a category archive
        	printf("<h2 class=\"page-title\">Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
        } else if ( is_date() ) { // If this is a date archive
        	echo("<h2 class=\"page-title\">Sorry, but there aren't any posts with this date.</h2>");
        } else if ( is_author() ) { // If this is a category archive
        	$userdata = get_userdatabylogin(get_query_var('author_name'));
        	printf("<h2 class=\"page-title\">Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
        } else {
        	echo("<h2 class=\"page-title\">No posts found.</h2>");
        }
        get_search_form();

        endif; ?>

        </div>

        <?php get_sidebar() ?>

	</div> <!-- #content -->

<?php get_footer() ?>