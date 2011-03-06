<?php

/*
 * Custom Content Type for Shows
 ***********************************************/

add_action('init', 'shows');

function shows() {
	
	$show_labels = array(
		'name' => __( 'Shows' ),
		'singular_name' => __( 'Show' ),
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Add New Show' ),
		'edit' => __( 'Edit' ),
		'edit_item' => __( 'Edit Show' ),
		'new_item' => __( 'New Show' ),
		'view' => __( 'View Show' ),
		'view_item' => __( 'View Show' ),
		'search_items' => __( 'Search Shows' ),
		'not_found' => __( 'No shows found' ),
		'not_found_in_trash' => __( 'No shows found in Trash' ),
		'parent' => __( 'Parent Show' ),
	);
	
	$args = array(
    	'labels' => $show_labels,
    	'public' => true,
    	'show_ui' => true,
    	'capability_type' => 'post',
		'menu_icon' => get_bloginfo('template_url') . '/assets/i/admin/ico_shows.png',
		'menu_position' => 5,
    	'hierarchical' => false,
    	'rewrite' => true,
    	'supports' => array('title', 'editor', 'thumbnail')
    );

	register_post_type( 'show' , $args );
	
	$labels_tours = array(
		'name' => _x( 'Tours', 'taxonomy general name' ),
		'singular_name' => _x( 'Tour', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Tours' ),
		'all_items' => __( 'All Tours' ),
		'parent_item' => __( 'Parent Tour' ),
		'parent_item_colon' => __( 'Parent Tour:' ),
		'edit_item' => __( 'Edit Tour' ), 
		'update_item' => __( 'Update Tour' ),
		'add_new_item' => __( 'Add New Tour' ),
		'new_item_name' => __( 'New Tour Name' ),
	);

	register_taxonomy('tour',array('show'), array(
		'hierarchical' => true,
		'labels' => $labels_tours,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'tour' ),
	));

	$labels_venue = array(
		'name' => _x( 'Venues', 'taxonomy general name' ),
		'singular_name' => _x( 'Venue', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Venues' ),
		'all_items' => __( 'All Venues' ),
		'parent_item' => __( 'Parent Venue' ),
		'parent_item_colon' => __( 'Parent Venue:' ),
		'edit_item' => __( 'Edit Venue' ), 
		'update_item' => __( 'Update Venue' ),
		'add_new_item' => __( 'Add New Venue' ),
		'new_item_name' => __( 'New Venue Name' ),
	);

	register_taxonomy('venue',array('show'), array(
		'hierarchical' => true,
		'labels' => $labels_venue,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'venue' ),
	));

	$labels_location = array(
		'name' => _x( 'Locations', 'taxonomy general name' ),
		'singular_name' => _x( 'Location', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Locations' ),
		'all_items' => __( 'All Locations' ),
		'parent_item' => __( 'Parent Location' ),
		'parent_item_colon' => __( 'Parent Location:' ),
		'edit_item' => __( 'Edit Location' ), 
		'update_item' => __( 'Update Location' ),
		'add_new_item' => __( 'Add New Location' ),
		'new_item_name' => __( 'New Location Name' ),
	);

	register_taxonomy('location',array('show'), array(
		'hierarchical' => true,
		'labels' => $labels_location,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'location' ),
	));

}

add_action('save_post', 'save_timedate');

function sourdough_show_get_artists() {
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

function meta_options(){
	global $post;

	if( !preg_match( "/post-new/",$_SERVER['REQUEST_URI'],$matches ) && isset( $post->ID ) ):	
		$datetime = get_post_meta($post->ID,'datetime',true);
		$d = date( "m/d/Y g:i A", strtotime($datetime) );
		$ticketlink = get_post_meta($post->ID,'ticketlink',true);

		$artist = get_post_meta($post->ID, 'show_meta_artist', true);
	endif;

	$_artists = sourdough_show_get_artists();

    if (!$_artists) {
        echo '<p>You must add atleast <em>one</em> <a href="post-new.php?post_type=artist">Artist</a> before you can add a Release!</p>';
    }
    else {
        echo '<p><label for="show_meta_artist">Artist</label>';
        echo '<select id="show_meta_artist" name="show_meta_artist">';

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
	
	echo '<label for="datetime">' .__("Showtime:") . "</label>";
	?>	
       	<input id="datetime" name="datetime" class="datetime" value="<?php echo $d; ?>" />
        <script type="text/javascript">
			jQuery("#datetime").AnyTime_picker({
                hideInput : false,
                placement : 'popup',
                askSecond : false,
                format	  : '%m/%d/%Y %l:%i %p',
                baseYear  : <?php echo date('Y'); ?>
            });
        </script>

	    <div class="clear"></div>
<?php
	echo '<label for="ticketlink">' .__("Ticket URL:") . "</label>";
?>
       	<input id="ticketlink" name="ticketlink" class="ticketlink" value="<?php echo $ticketlink; ?>" />
<?php
	echo '<label for="admission">' .__("Admission Info:") . "</label>";
?>
       	<input id="admission" name="admission" class="admission" value="<?php echo $admission; ?>" />
<?php

}

function save_timedate(){
	global $post;
	if($_REQUEST['action'] != 'autosave'):
		update_post_meta($post->ID, "datetime", date("YmdHi00", strtotime($_POST["datetime"]) ) );
		update_post_meta($post->ID, "ticketlink", $_REQUEST['ticketlink'] );
		update_post_meta($post->ID, "admission", $_REQUEST['admission'] );

	    if ($_POST["show_meta_artist"] != ""){
	        if (!update_post_meta($post->ID, "show_meta_artist", $_POST["show_meta_artist"]))
	            add_post_meta($post->ID, "show_meta_artist", $_POST["show_meta_artist"], true);
	    }
	endif;
}

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'load_shows_widget' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function load_shows_widget() {
	register_widget( 'Shows' );
}

/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class Shows extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Shows() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_shows', 'description' => __('A widget to display a listing of upcoming shows.', 'garageband') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'shows' );

		/* Create the widget. */
		$this->WP_Widget( 'shows', __('Shows', 'garageband'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$number = $instance['number'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		rewind_posts();
		wp_reset_query();
		
		$count;
		
		$args = array('post_type' 	=> 'show',
					  'orderby' 	=> 'datetime',
					  'meta_key'	=> 'datetime',
					  'order'		=> 'ASC');

		query_posts($args);
		
		?>
		
		<?php if( have_posts() ) : ?>

            <ul id="gigs">

			<?php while( have_posts() && $count < $number ): the_post(); ?>
            
            <?php
			
			$location = get_the_term_list( get_the_ID(), 'location', '', ', ', '' );
			$venue = get_the_term_list( get_the_ID(), 'venue', '', ', ', '' );
			$tour = get_the_term_list( get_the_ID(), 'tour', '', ', ', '' );
			$date = get_post_meta(get_the_ID(), "timedate", true);
			
			?>
            	<li class="gig">
                    <span class="tour"><?php echo $tour; ?></span>
                	<h4>
	                	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                    <?php $ticketlink = get_post_meta(get_the_ID(),'ticketlink',true); ?>
	                    <?php if( $ticketlink ): ?>
	                     <a class="ticketlink" href="<?php echo $ticketlink; ?>">(<span><?php _e("tickets","garageband"); ?></span>)</a>
	                    <?php endif; ?>
                	</h4>
                	<span class="date">
                    	<?php
                        $timestamp = get_post_meta(get_the_ID(), 'datetime', true);
            			echo convert_timestamp($timestamp, "g:s A, F d, Y") . " ";
                        ?>
                    </span>
                    <span class="location"><?php echo $venue; ?> <?php if($location) { echo " in " . $location; } ?></span>
                </li>
                
			<?php $count++; endwhile; ?>
            
            </ul>
                        
        <?php endif; ?>

		<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		/* No need to strip tags for number. */
		$instance['number'] = $new_instance['number'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Upcoming Shows', 'garageband'), 'number' => '5' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'garageband'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Number: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number:', 'garageband'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( '1' == $instance['number'] ) echo 'selected="selected"'; ?>>1</option>
				<option <?php if ( '2' == $instance['number'] ) echo 'selected="selected"'; ?>>2</option>
				<option <?php if ( '3' == $instance['number'] ) echo 'selected="selected"'; ?>>3</option>
				<option <?php if ( '4' == $instance['number'] ) echo 'selected="selected"'; ?>>4</option>
				<option <?php if ( '5' == $instance['number'] ) echo 'selected="selected"'; ?>>5</option>
				<option <?php if ( '6' == $instance['number'] ) echo 'selected="selected"'; ?>>6</option>
				<option <?php if ( '7' == $instance['number'] ) echo 'selected="selected"'; ?>>7</option>
				<option <?php if ( '8' == $instance['number'] ) echo 'selected="selected"'; ?>>8</option>
				<option <?php if ( '9' == $instance['number'] ) echo 'selected="selected"'; ?>>9</option>
				<option <?php if ( '10' == $instance['number'] ) echo 'selected="selected"'; ?>>10</option>
			</select>
		</p>

	<?php
	}
}