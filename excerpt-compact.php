<div id="post-<?php the_ID() ?>" class="post">

    <h2 class="title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title() ?>" rel="bookmark"><?php the_title() ?></a></h2>

    <div class="byline">
        Posted <abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_relative_date() ?></abbr> by <?php the_author_link() ?>
    </div>

    <div class="excerpt"><?php the_excerpt() ?></div>

</div>