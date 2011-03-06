<?php 

/*
# Release
Add the Release content type.

## Fields
 - Title
 - Photo (featured image)
 - Links (Custom Fields)
*/

add_action('init', 'release_init');

function release_init() {
    $labels = array(
        'name'              => __('Releases', 'post type general name'),
        'singular_name'     => __('Release', 'post type singular name'),
        'add_new'           => __('Add New', 'release'),
        'add_new_item'      => __('Add New Release'),
        'edit_item'         => __('Edit Release'),
        'new_item'          => __('New Release'),
        'view_item'         => __('View Release'),
        'search_items'      => __('Search Releases'),
        'not_found'         => __('No releases found'),
        'not_found_in_trash'=> __('No releases found in Trash'), 
        'parent_item_colon' => ''
    );

    $args = array(
        'labels'            => $labels,
        'public'            => true,
        'publicly_queryable'=> true,
        'show_ui'           => true, 
        'query_var'         => true,
        'rewrite'           => array('slug' => 'releases'),
        'capability_type'   => 'page',
        'hierarchical'      => false,
        'menu_position'     => 5,
        'menu_icon'         => get_bloginfo('template_url') . '/assets/i/admin/ico_releases.png',
        'supports'          => array('title', 'thumbnail')
    );

    register_post_type('release', $args);
}

add_filter('post_updated_messages', 'release_updated_messages');

function release_updated_messages( $messages ) {
    global $post, $post_ID;

    $messages['release'] = array(
        0 => '', // Unused. Messages start at index 1.
        1 => sprintf( __('Release updated. <a href="%s">View release</a>'), esc_url( get_permalink($post_ID) ) ),
        2 => __('Custom field updated.'),
        3 => __('Custom field deleted.'),
        4 => __('Release updated.'),
        /* translators: %s: date and time of the revision */
        5 => isset($_GET['revision']) ? sprintf( __('Release restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6 => sprintf( __('Release created. <a href="%s">View release</a>'), esc_url( get_permalink($post_ID) ) ),
        7 => __('Release saved.'),
        8 => sprintf( __('Release submitted. <a target="_blank" href="%s">Preview release</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        9 => sprintf( __('Release scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview release</a>'),
        // translators: Publish box date format, see http://php.net/date
        date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
        10 => sprintf( __('Release draft updated. <a target="_blank" href="%s">Preview release</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    );

    return $messages;
}

function sourdough_release_get_artists() {
    $titles = array();

    // query all artist or return false
    $artists = get_posts(array(
        'post_type' => 'artist',
        'numberposts' => -1
    ));

    if ($artists) {
        foreach ($artists as $post) {
            setup_postdata($post);
            $titles[] = $post->post_title;
        }

        return $titles;
    }

    return false;
}

function sourdough_add_release_meta() {
    add_meta_box('release_meta', __( 'Release Details', 'sourdough' ), 'sourdough_release_meta_callback', 'release', 'normal');
}
add_action('add_meta_boxes', 'sourdough_add_release_meta');

function sourdough_release_meta_callback() {
    global $post;

    $_data['download'] = get_post_meta($post->ID, 'release_meta_download', true);
    $_data['listen']   = get_post_meta($post->ID, 'release_meta_listen', true);
    $_data['artist']   = get_post_meta($post->ID, 'release_meta_artist', true);

    $_artists = sourdough_release_get_artists();

    if (!$_artists) {
        echo '<p>You must add atleast <em>one</em> <a href="post-new.php?post_type=artist">Artist</a> before you can add a Release!</p>';
    }
    else {
        wp_nonce_field(plugin_basename(__FILE__), 'sourdough_release_meta_noncename');

        echo '<div class="sourdough_meta_box">';

        echo '<p><label for="release_meta_artist">Artist</label>';
        echo '<select id="release_meta_artist" name="release_meta_artist">';
        foreach ($_artists as $v) {
            if ($_data['artist'] == $v) {
                echo '<option value="'.$v.'" selected="selected">'.ucwords($v).'</option>';
            }
            else {
                echo '<option value="'.$v.'">'.ucwords($v).'</option>';
            }
        }
        echo '</select></p>';

        foreach ($_data as $k => $v) {
            if ($k == 'artist') {
                break;
            }
            echo '<p><label for="release_meta_'.$k.'">'.ucwords($k).' URL</label>';
            echo '<input name="release_meta_'.$k.'" id="release_meta_'.$k.'" type="text" value="'.$v.'"></p>';
        }

        echo '<div style="clear:left"></div></div>';
    }
}

function sourdough_save_release_meta($post_id) {
    // Authenticate
    if (!wp_verify_nonce($_POST['sourdough_release_meta_noncename'], plugin_basename(__FILE__)))
        return $post_id;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
        return $post_id;

    if ('release' !== $_POST['post_type'])
        return $post_id;

    // Save _data
    $_data['release_meta_download'] = '';
    $_data['release_meta_listen'] = '';
    $_data['release_meta_artist'] = '';

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
add_action('save_post', 'sourdough_save_release_meta');

?>