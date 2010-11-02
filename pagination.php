<?php if ( is_single() ) : ?>

<div class="pagination clearfix">
    <span class="prev button"><?php next_post_link('%link', '&lt;'); ?></span>
    <span class="next button"><?php previous_post_link('%link', '&gt;'); ?></span>
</div>

<?php else: ?>

<div class="pagination clearfix">
    <?php
    if (function_exists('wp_pagenavi')) {
        wp_pagenavi();
    }
    else { ?>
        <span class="prev button"><?php next_posts_link('%link', '&lt;'); ?></span>
        <span class="next button"><?php previous_posts_link('%link', '&gt;'); ?></span>
    <?php } ?>
</div>

<?php endif; ?>