<?php
/*
    Sourdough Helpers

    Here are some functions to help make themeing with sourdough easier.
    These can be overridden in a child theme.
*/

if (!function_exists('sourdough_get_categories')) {
    function sourdough_get_categories( $sep = ', ', $before = '', $after = '' ) {
        /*
        Echoes the categories with the parent of each as a css class.
        Allows you to style each category link based on it's parent.
        Must be used within the loop.

        Example:
            <a href="/category" class="parent-class">cagtegory Name</a>
        */
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
}

if (!function_exists('sourdough_list_children')) {
    function sourdough_list_children( ) {
        /*
        Echoes an unordered list of links to all children
        of the current parent category or page.

        Even when viewing a child page, we find the parent
        and output all of its children.
        */
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
}

?>