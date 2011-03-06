<?php

function parse_feed($feed) {
    $stepOne = explode("<content type=\"html\">", $feed);
    $stepTwo = explode("</content>", $stepOne[1]);
    $tweet = $stepTwo[0];
    $tweet = htmlspecialchars_decode($tweet,ENT_QUOTES);
    return $tweet;
}

function latest_tweet($username){
    $feed = "http://search.twitter.com/search.atom?q=from:".$username."&rpp=1";
    $twitterFeed = file_get_contents($feed);
    $link = '<p><a href="http://twitter.com/'.$username.'">Follow on Twitter</a></p>';

    return '<p class="big">'.parse_feed($twitterFeed).'</p>'.$link;
}

if ( !class_exists( 'LatestTweet' ) ) :
    class LatestTweet extends WP_Widget {
        /*
            Display the latest tweet for an account.
        */
        function LatestTweet( ) {
            $widget_ops = array(
                'classname' => 'latestTweet-widget',
                'description' => __( 'Display the latest tweet for an account.' )
            );
            $this->WP_Widget('latestTweet-widget', __('Latest Tweet'), $widget_ops);
        }

        function widget( $args, $instance ) {
            $title = empty($instance['title']) ? __('Twitter', 'latestTweet-widget') : apply_filters('widget_title', $instance['title']);

            echo $args['before_widget'];
            echo $args['before_title'].$title.$args['after_title'];

            // Must be used with the light-organ-theme
            if (function_exists(latest_tweet)) {
                $instance['username'] = (empty($instance['username'])) ? 'lightorgan' : $instance['username'];
                echo latest_tweet($instance['username']);
            }
            else {
                echo 'This widget is only compatible within the light-organ-theme theme!';
            }

            echo $args['after_widget'];
        }
        
        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['username'] = strip_tags( $new_instance['username'] );
            $instance['title'] = strip_tags( $new_instance['title'] );
            return $instance;
        }

        function form( $instance ) {
            $username = esc_attr( $instance['username'] );
            $title = esc_attr( $instance['title'] );
            ?>

            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"></p>

            <p><label for="<?php echo $this->get_field_id('username'); ?>"><?php _e( 'Twitter Username:' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>"></p>

            <?php
        }
    }

function register_LatestTweet() {
    register_widget( 'LatestTweet' );
}
add_action( 'widgets_init', 'register_LatestTweet' );

endif;