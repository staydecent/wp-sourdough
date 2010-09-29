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
    $f = TEMPLATEPATH.'/'.$filename.'.php';
    if (file_exists($f)) {
        include $f;
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
    $f = TEMPLATEPATH.'/'.$filename.'.php';
    if (file_exists($f)) {
        include $f;
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
    $f = TEMPLATEPATH.'/'.$filename.'.php';
    if (file_exists($f)) {
        include $f;
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
    $f = TEMPLATEPATH.'/'.$filename.'.php';
    if (file_exists($f)) {
        include $f;
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
function sourdough_get_categories( $sep = ', ' ) {
    $total_cats = count(get_the_category());
    $i = 0;
    foreach((get_the_category()) as $cat) {
        ++$i;
        $parent = get_category( $cat->parent );
        $link   = get_category_link( $cat->cat_ID );

        if(!$parent->errors) {
            echo '<a href="'.$link.'" title="'.$cat->name.'" class="'.$parent->slug.'">'.$cat->name.'</a>';
        } else {
            echo '<a href="'.$link.'" title="'.$cat->name.'">'.$cat->name.'</a>';
        }
        
        if($i < $total_cats) echo $sep;
    } 
}
endif;
?>