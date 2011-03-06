<?php 

// Registers the new post type and taxonomy
 
function video_posttype() {
    register_post_type( 'video',
        array(
            'labels' => array(
                'name' => __( 'Videos' ),
                'singular_name' => __( 'Video' ),
                'add_new' => __( 'Add New Video' ),
                'add_new_item' => __( 'Add New Video' ),
                'edit_item' => __( 'Edit Video' ),
                'new_item' => __( 'Add New Video' ),
                'view_item' => __( 'View Video' ),
                'search_items' => __( 'Search Video' ),
                'not_found' => __( 'No videos found' ),
                'not_found_in_trash' => __( 'No videos found in trash' )
            ),
            'public'            => true,
            'publicly_queryable'=> true,
            'show_ui'           => true, 
            'query_var'         => true,
            'supports'          => array( 'title', 'editor', 'thumbnail', 'comments'),
            'capability_type'   => 'post',
            'rewrite'           => array("slug" => "videos"), // Permalinks format
            'menu_icon'         => get_bloginfo('stylesheet_directory') . '/assets/i/admin/videos.png',  // Icon Path
            'menu_position'     => 5,
        )
    );
}
 
add_action( 'init', 'video_posttype' );

// Change the "Scheduled for" text on Video post types changing the translation
// http://blog.ftwr.co.uk/archives/2010/01/02/mangling-strings-for-fun-and-profit/
function translation_mangler2($translation, $text, $domain) {
    global $post;

    if ($post->post_type == 'videos') {
 
        $translations = &get_translations_for_domain( $domain);
        if ( $text == 'Scheduled for: <b>%1$s</b>') {
            return $translations->translate( 'Video Date: <b>%1$s</b>' );
        }
        if ( $text == 'Published on: <b>%1$s</b>') {
            return $translations->translate( 'Video Date: <b>%1$s</b>' );
        }
        if ( $text == 'Publish <b>immediately</b>') {
            return $translations->translate( 'Video Date: <b>%1$s</b>' );
        }
    }
 
    return $translation;
}
 
add_filter('gettext', 'translation_mangler2', 10, 4);



function sourdough_video_get_artists() {
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


add_action("admin_init", "admin_init_videos");
add_action('save_post', 'save_video_info');

function admin_init_videos(){
    add_meta_box("videosInfo-meta", "Video Info", "videos_meta_options", "video", "normal", "high");
}

function videos_meta_options(){
    ?>
    <p class="meta-options">
    <?php
    //call the fields
    videos_file_options();
    ?>
    </p>
    <?php
}


function videos_file_options(){
    global $post;

    $custom = get_post_custom($post->ID);
    $videolink = get_post_meta($post->ID, 'videolink', true);
    $artist = get_post_meta($post->ID, 'video_meta_artist', true);

    $_artists = sourdough_video_get_artists();

    echo '<div class="sourdough_meta_box">';

    if (!$_artists) {
        echo '<p>You must add atleast <em>one</em> <a href="post-new.php?post_type=artist">Artist</a> before you can add a Release!</p>';
    }
    else {
        echo '<p><label for="video_meta_artist">Artist</label>';
        echo '<select id="video_meta_artist" name="video_meta_artist">';

        foreach ($_artists as $v) {
            if ($artist == $v) {
                echo '<option value="'.$v.'" selected="selected">'.ucwords($v).'</option>';
            }
            else {
                echo '<option value="'.$v.'">'.ucwords($v).'</option>';
            }
        }
        echo '</select></p>';
        echo '<div style="clear:left"></div>';
    }
    ?>

    <p>
    <label for="videolink">Video ID:</label>
    <input name="videolink" type="text" value="<?php echo $videolink; ?>">
    </p>

    <p>
        Grab the Video ID from the URL:<br>
        <em>http://www.youtube.com/watch?v=<strong>kUlgN__Jrxk</strong></em><br>
        <span style="padding-left:60px;">&mdash;OR&mdash;</span><br>
        <em>http://vimeo.com/<strong>19474258</strong></em>
    </p>

    <?php
    echo '<div style="clear:left"></div></div>';
}


function save_video_info() {
    global $post;
    if ($_POST["videolink"] != ""){
        update_post_meta($post->ID, "videolink", $_POST["videolink"]);
    }
    if ($_POST["video_meta_artist"] != ""){
        if (!update_post_meta($post->ID, "video_meta_artist", $_POST["video_meta_artist"]))
            add_post_meta($post->ID, "video_meta_artist", $_POST["video_meta_artist"], true);
    }
}