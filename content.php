<div id="post-<?php the_ID() ?>" class="post">

    <h2 class="title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title() ?>" rel="bookmark"><?php the_title() ?></a></h2>

    <div class="byline">
        Posted <abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_relative_date() ?></abbr> by <?php the_author_link() ?>
    </div>

    <?php if ( has_post_thumbnail() ) : ?>
    <div class="image"><?php the_post_thumbnail( 'post-image' ) ?></div>
    <?php endif; ?>

    <div class="content"><?php the_content() ?></div>

    <div class="meta">
        <span class="categories">
            <strong>Filed Under</strong>&mdash;
            <?php the_category(', ') ?>
        </span><br>
        <span class="tags">
            <strong>Tagged With</strong>&mdash;
            <?php the_tags(', '); ?>
        </span>
    </div>

</div>