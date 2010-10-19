<div id="feature" class="column twelve clearfix">

    <div id="post-<?php the_ID() ?>" class="post">

        <div class="content column four">
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

        <div class="image column eight">
            <a href="<?php the_permalink() ?>" title="Permalink to <?php the_title() ?>" rel="bookmark"><?php the_post_thumbnail('post-image') ?></a>
        </div>

    </div>

</div>