<div id="post-<?php the_ID() ?>" class="post column two<?php echo ($post_count % 3 == 0) ? ' last' : ''; ?>">

    <h2 class="title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title() ?>" rel="bookmark"><?php the_title() ?></a></h2>

    <div class="byline">
        Posted <abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_relative_date() ?></abbr> by <?php the_author_link() ?>
    </div>

<?php if ( has_post_thumbnail() ) : ?>
    <div class="thumbnail">
        <a href="<?php the_permalink() ?>" title="Permalink to <?php the_title() ?>" rel="bookmark"><?php the_post_thumbnail() ?></a>
    </div>
<?php else: ?>
    <div class="excerpt"><?php the_excerpt() ?></div>
<?php endif; ?>

    <div class="meta">
        <span class="categories"><?php sourdough_get_categories() ?></span> <span class="meta-sep">&bull;</span>
        <span class="comments"><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></span>
    </div>

</div>