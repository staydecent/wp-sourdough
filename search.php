<?php 
    get_header();
    //sourdough_before_content();
?>

	<div id="content" class="column twelve">
        <div id="archive" class="column eight">
		
		<?php if (have_posts()) : ?>

		<h2 class="page-title"><?php printf( __( 'Search Results for %s', 'sourdough' ), '&ldquo;'.get_search_query().'&rdquo;' ); ?></h2>

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

        	echo "<h2 class=\"page-title\">No posts found. Try a different search.";
        	get_search_form();

        endif; ?>

        </div>

        <?php get_sidebar() ?>

	</div> <!-- #content -->

<?php get_footer() ?>