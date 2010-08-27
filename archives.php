<?php get_header() ?>

    <div id="body">
        <div class="container">

            <div id="content" class="left">

                <?php get_search_form(); ?>

                <h2>Archives by Month:</h2>
                <ul>
                    <?php wp_get_archives('type=monthly'); ?>
                </ul>

                <h2>Archives by Subject:</h2>
                <ul>
                    <?php wp_list_categories(); ?>
                </ul>

            </div><!-- #content -->

<?php get_sidebar() ?>

        </div>
    </div>

<?php get_footer() ?>