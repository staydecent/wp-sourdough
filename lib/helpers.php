<?php 
/*
    Sourdough Helpers

    Here are some functions to help make themeing with sourdough easier.
    These can be overridden in a child theme.
*/

/*
    Loads the `excerpt.php` theme file, otherwise echo's some preset html.
    Preference is given to the theme file, to allow for easier customization and collaboration.

    It is not recommended that you edit the preset html in this function, it is just a fall back.
*/
if (!function_exists('sourdough_excerpt')) :
function sourdough_excerpt( $post_count, $filename = 'excerpt' ) {
    $fs = STYLESHEETPATH.'/'.$filename.'.php';
    $ft = TEMPLATEPATH.'/'.$filename.'.php';
    if ( file_exists($fs) ) {
        include $fs;
    }
    elseif ( $ft ) {
        include $ft;
    }
    else { ?>
    <div id="post-<?php the_ID() ?>" class="post">

        <h2 class="title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title() ?>" rel="bookmark"><?php the_title() ?></a></h2>

        <div class="byline">
            Posted <abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_relative_date() ?></abbr> by <?php the_author_link() ?>
        </div>

        <div class="excerpt"><?php the_excerpt() ?></div>

        <div class="meta">
            <span class="categories"><?php the_category(', ') ?></span>
            <span class="comments"><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></span>
        </div>

    </div>
    <?php }
}
endif;

/*
    Loads the `content.php` theme file, otherwise echo's some preset html.
    Preference is given to the theme file, to allow for easier customization and collaboration.

    It is not recommended that you edit the preset html in this function, it is just a fall back.
*/
if (!function_exists('sourdough_content')) :
function sourdough_content( $filename = 'content' ) {
    $fs = STYLESHEETPATH.'/'.$filename.'.php';
    $ft = TEMPLATEPATH.'/'.$filename.'.php';
    if ( file_exists($fs) ) {
        include $fs;
    }
    elseif ( $ft ) {
        include $ft;
    }
    else { ?>
    <div id="post-<?php the_ID() ?>" class="post">

        <h2 class="title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title() ?>" rel="bookmark"><?php the_title() ?></a></h2>

        <div class="byline">
            Posted <abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_relative_date() ?></abbr> by <?php the_author_link() ?>
        </div>

        <div class="content"><?php the_content() ?></div>

        <div class="meta">
            <span class="categories"><?php the_category(', ') ?></span>
            <span class="comments"><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></span>
        </div>

    </div>
    <?php }
}
endif;

/*
    Loads the `feature.php` theme file, otherwise echo's some preset html.
    Preference is given to the theme file, to allow for easier customization and collaboration.

    It is not recommended that you edit the preset html in this function, it is just a fall back.
*/
if (!function_exists('sourdough_feature')) :
function sourdough_feature( $filename = 'feature' ) {
    $fs = STYLESHEETPATH.'/'.$filename.'.php';
    $ft = TEMPLATEPATH.'/'.$filename.'.php';
    if ( file_exists($fs) ) {
        include $fs;
    }
    elseif ( $ft ) {
        include $ft;
    }
    else { ?>
    <div id="feature" class="container">
        <div id="post-<?php the_ID() ?>" class="post">

            <div class="thumbnail"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title() ?>" rel="bookmark"><?php the_post_thumbnail('header-image') ?></a></div>

            <h2 class="title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title() ?>" rel="bookmark"><?php the_title() ?></a></h2>

        </div>
    </div>
    <?php }
}
endif;

/*
    Loads the `pagination.php` theme file, otherwise echo's some preset html.
    Preference is given to the theme file, to allow for easier customization and collaboration.

    It is not recommended that you edit the preset html in this function, it is just a fall back.
*/
if (!function_exists('sourdough_pagination')) :
function sourdough_pagination( $filename = 'pagination' ) {
    $fs = STYLESHEETPATH.'/'.$filename.'.php';
    $ft = TEMPLATEPATH.'/'.$filename.'.php';
    if ( file_exists($fs) ) {
        include $fs;
    }
    elseif ( $ft ) {
        include $ft;
    }
    else { 
        if (function_exists('wp_pagenavi')) {
            wp_pagenavi();
        }
        else {
        ?>
        <div class="pagination clearfix">
            <div class="previous left"><?php previous_posts_link(); ?></div>
            <div class="next right"><?php next_posts_link(); ?></div>
        </div>
        <?php }
    }
}
endif;

/*
    Echoes the categories with the parent of each as a css class.
    Allows you to style each category link based on it's parent.
    Must be used within the loop.

    Example:
        <a href="/category" class="parent-class">cagtegory Name</a>
*/
if (!function_exists('sourdough_get_categories')) :
function sourdough_get_categories( $sep = ', ', $before = '', $after = '' ) {
    $total_cats = count(get_the_category());
    $i = 0;
    foreach((get_the_category()) as $cat) {
        ++$i;
        $parent = get_category( $cat->parent );
        $link   = get_category_link( $cat->cat_ID );

        echo $before;

        if(!$parent->errors) {
            echo '<a href="'.$link.'" title="'.$cat->name.'" class="'.$parent->slug.'">'.$cat->name.'</a>';
        } else {
            echo '<a href="'.$link.'" title="'.$cat->name.'">'.$cat->name.'</a>';
        }
        
        if($i < $total_cats) echo $sep;

        echo $after;
    } 
}
endif;

/*
    Echoes an unordered list of links to all children
    of the current parent category or page.

    Even when viewing a child page, we find the parent
    and output all of its children.
*/
if (!function_exists('sourdough_list_children')) :
function sourdough_list_children( ) {
    if ( is_category() ) {
        $cat = (int) get_query_var('cat');
        $term = get_term($cat, 'category');
        // If a child cat, then list all children of it's parent
        $parent = ($term->parent) ? (int) $term->parent : $cat;
        wp_list_categories(array(
            'child_of' => $parent,
            'title_li' => ''
        ));
    }
    elseif ( is_page() ) {
        $page = get_page_by_title(get_the_title());
        $parent = ($page->post_parent) ? (int) $page->post_parent : $page->ID;
        wp_list_pages(array(
            'child_of' => $parent,
            'title_li' => ''
        ));
    }
}
endif;
?>