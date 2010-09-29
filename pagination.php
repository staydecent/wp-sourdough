<div class="pagination clearfix">
    <?php
    if (function_exists('wp_pagenavi')) {
        wp_pagenavi();
    }
    else { ?>
        <div class="previous left"><?php previous_posts_link(); ?></div>
        <div class="next right"><?php next_posts_link(); ?></div>
    <?php } ?>
</div>