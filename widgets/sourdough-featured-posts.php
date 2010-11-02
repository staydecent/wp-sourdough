<?php
if ( !class_exists( 'SourdoughFeaturedPosts' ) ) :
    class SourdoughFeaturedPosts extends WP_Widget {
        /*
            Displays the featured posts template.
             Widgetized for flexibility -> Layout changes
             for child themes is less strict.
        */
        function SourdoughFeaturedPosts( ) {
            $widget_ops = array(
                'classname' => 'featuredposts-widget',
                'description' => __( 'Displays featured posts.' )
            );
            $this->WP_Widget('featuredposts-widget', __('Sourdough Featured Posts'), $widget_ops);
        }

        function widget( $args, $instance ) {
            if ( !is_home() ) {
                return false;
            }
            
            /*
                Query the first post:
                 If it has a featured image, display it,
                 and store its ID in an array.
            */
            query_posts('posts_per_page=1');
            while ( have_posts() ) { 
                the_post();
                /*
                    Check if the post has a featured image:
                     If true, display inside #featured
                */
                if ( has_post_thumbnail() ) {
                    $do_not_duplicate[] = $post->ID;
                    /*
                        See: lib/helpers.php -> sourdough_feature()
                    */
                    sourdough_feature();
                }
            }

            /*
                Excerpt post loop.
                 If a #feature post exists, do not duplicate.
            */
            if ( (int) $instance['excerpts_count'] > 0 ) {
                query_posts( array(
                    'post__not_in' => $do_not_duplicate,
                    'offset' => 1,
                    'posts_per_page' => (int) $instance['excerpts_count']
                ) );

                echo '<div class="clearfix">';

                for ( $post_count = 1; have_posts(); $post_count++) {
                    the_post();
                    $do_not_duplicate[] = $post->ID;
                    /*
                        See: lib/helpers.php -> sourdough_excerpt()
                    */
                    sourdough_excerpt( $post_count );
                }

                echo '</div>';
            }
        }
        
        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['excerpts_count'] = strip_tags( $new_instance['excerpts_count'] );
            return $instance;
        }

        function form( $instance ) {
            $excerpts_count = esc_attr( $instance['excerpts_count'] );
            ?>

            <p><label for="<?php echo $this->get_field_id('excerpts_count'); ?>"><?php _e( '# Of Featured Excerpts:' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('excerpts_count'); ?>" name="<?php echo $this->get_field_name('excerpts_count'); ?>" type="text" value="<?php echo $excerpts_count; ?>"></p>

            <?php
        }
    }

function register_SourdoughFeaturedPosts() {
    register_widget( 'SourdoughFeaturedPosts' );
}
add_action( 'widgets_init', 'register_SourdoughFeaturedPosts' );

endif;