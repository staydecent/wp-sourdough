<?php 

/*
# Artist
Add the Artist content type.

## Fields
 - Name (title)
 - Photo (featured image)
 - Description (custom)
 - Links (Custom Fields)
*/

add_action('init', 'artist_init');

function artist_init() {
    $labels = array(
        'name'              => __('Artists', 'post type general name'),
        'singular_name'     => __('Artist', 'post type singular name'),
        'add_new'           => __('Add New', 'artist'),
        'add_new_item'      => __('Add New Artist'),
        'edit_item'         => __('Edit Artist'),
        'new_item'          => __('New Artist'),
        'view_item'         => __('View Artist'),
        'search_items'      => __('Search Artists'),
        'not_found'         => __('No artists found'),
        'not_found_in_trash'=> __('No artists found in Trash'), 
        'parent_item_colon' => ''
    );

    $args = array(
        'labels'            => $labels,
        'public'            => true,
        'publicly_queryable'=> true,
        'show_ui'           => true, 
        'query_var'         => true,
        'rewrite'           => array('slug' => 'artists'),
        'capability_type'   => 'page',
        'hierarchical'      => false,
        'menu_position'     => 5,
        'menu_icon'         => get_bloginfo('template_url') . '/assets/i/admin/ico_releases.png',
        'supports'          => array('title', 'thumbnail', 'editor')
    );

    register_post_type('artist', $args);
}

add_filter('post_updated_messages', 'artist_updated_messages');

function artist_updated_messages( $messages ) {
    global $post, $post_ID;

    $messages['artist'] = array(
        0 => '', // Unused. Messages start at index 1.
        1 => sprintf( __('Artist updated. <a href="%s">View artist</a>'), esc_url( get_permalink($post_ID) ) ),
        2 => __('Custom field updated.'),
        3 => __('Custom field deleted.'),
        4 => __('Artist updated.'),
        /* translators: %s: date and time of the revision */
        5 => isset($_GET['revision']) ? sprintf( __('Artist restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6 => sprintf( __('Artist created. <a href="%s">View artist</a>'), esc_url( get_permalink($post_ID) ) ),
        7 => __('Artist saved.'),
        8 => sprintf( __('Artist submitted. <a target="_blank" href="%s">Preview artist</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        9 => sprintf( __('Artist scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview artist</a>'),
        // translators: Publish box date format, see http://php.net/date
        date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
        10 => sprintf( __('Artist draft updated. <a target="_blank" href="%s">Preview artist</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    );

    return $messages;
}

function sourdough_add_artist_links() {
    add_meta_box('artist_links', __( 'Artist Links', 'sourdough' ), 'sourdough_artist_links_callback', 'artist', 'normal');
}
add_action('add_meta_boxes', 'sourdough_add_artist_links');

function sourdough_artist_links_callback() {
    global $post;

    $_data['facebook']  = get_post_meta($post->ID, 'artist_links_facebook', true);
    $_data['twitter']   = get_post_meta($post->ID, 'artist_links_twitter', true);
    $_data['myspace']   = get_post_meta($post->ID, 'artist_links_myspace', true);
    $_data['youtube']   = get_post_meta($post->ID, 'artist_links_youtube', true);
    $_data['vimeo']     = get_post_meta($post->ID, 'artist_links_vimeo', true);
    $_data['lastfm']    = get_post_meta($post->ID, 'artist_links_lastfm', true);

    wp_nonce_field(plugin_basename(__FILE__), 'sourdough_artist_links_noncename');

    echo '<div class="sourdough_meta_box">';

    foreach ($_data as $k => $v) {
        echo '<p><label for="artist_links_'.$k.'">'.ucwords($k).'</label>';
        echo '<input name="artist_links_'.$k.'" id="artist_links_'.$k.'" type="text" value="'.$v.'"></p>';
    }

    echo '<div style="clear:left"></div></div>';
}

function sourdough_save_artist_meta($post_id) {
    // Authenticate
    if (!wp_verify_nonce($_POST['sourdough_artist_links_noncename'], plugin_basename(__FILE__)))
        return $post_id;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
        return $post_id;

    if ('artist' !== $_POST['post_type'])
        return $post_id;

    // Save _data
    $_data['artist_links_facebook'] = '';
    $_data['artist_links_twitter'] = '';
    $_data['artist_links_myspace'] = '';
    $_data['artist_links_youtube'] = '';
    $_data['artist_links_vimeo'] = '';
    $_data['artist_links_lastfm'] = '';

    foreach ($_data as $k => $v) {
        if (isset($_POST[$k])) {
            $_data[$k] = $_POST[$k];
            // sweet moses we found data
            if (!update_post_meta($post_id, $k, $_data[$k])) {
               // lord ol mighty it doesnt exist, so add!
               add_post_meta($post_id, $k, $_data[$k], true);
            }
        }
    }

    return true;
}
add_action('save_post', 'sourdough_save_artist_meta');

?>