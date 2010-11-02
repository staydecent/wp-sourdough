<?php
/*
    Log the ID of the featured post
    so we can skip it in the main loop.
*/
do_not_duplicate(get_the_ID());
?>
<div id="feature" class="clearfix">

    <div id="post-<?php the_ID() ?>" class="post">

        <div class="content column two">
            <h2 class="title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title() ?>" rel="bookmark"><?php the_title() ?></a></h2>

            <div class="byline">
                Posted <abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_relative_date() ?></abbr> by <?php the_author_link() ?>
            </div>

            <div class="excerpt">
                <?php the_excerpt() ?>
            </div>

            <div class="meta">
                <span class="categories"><?php sourdough_get_categories() ?></span> <span class="meta-sep">&bull;</span>
                <span class="comments"><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></span>
            </div>
        </div>

        <div class="image column four">
            <a href="<?php the_permalink() ?>" title="Permalink to <?php the_title() ?>" rel="bookmark"><?php the_post_thumbnail('post-image') ?></a>
        </div>

    </div>

</div>