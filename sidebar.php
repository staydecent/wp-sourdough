    <div class="sidebar span4">

    <?php if ( is_home() ) : ?>
		<div id="home-sidebar">	
		<?php if (!dynamic_sidebar( 'home-sidebar' )) : ?>
		<?php endif; ?>
		</div>
    <?php elseif ( is_single() ) : ?>
        <div id="single-sidebar">  
        <?php if (!dynamic_sidebar( 'single-sidebar' )) : ?>
        <?php endif; ?>
        </div>
    <?php elseif ( is_page(array('artists','Artists','artist','Artist')) ) : ?>
        <div id="artist-sidebar">  
        <?php if (!dynamic_sidebar( 'artist-sidebar' )) : ?>
        <?php endif; ?>
        </div>
    <?php elseif ( is_page(array('news','News','blog','Blog')) ) : ?>
        <div id="news-sidebar">  
        <?php if (!dynamic_sidebar( 'news-sidebar' )) : ?>
        <?php endif; ?>
        </div>
    <?php elseif ( is_page(array('shows','Shows','tour-dates','Tour Dates')) ) : ?>
        <div id="shows-sidebar">  
        <?php if (!dynamic_sidebar( 'shows-sidebar' )) : ?>
        <?php endif; ?>
        </div>
    <?php else : ?>
        <div id="common-sidebar">  
        <?php if (!dynamic_sidebar( 'common-sidebar' )) : ?>
        <?php endif; ?>
        </div>
    <?php endif; ?>

    </div>