    <div class="sidebar column two">

    <?php if ( is_home() ) : ?>
		<div id="home">	
		<?php if (!dynamic_sidebar( 'home-sidebar' )) : ?>
		<?php endif; ?>
		</div>
    <?php elseif ( is_single() ) : ?>
        <div id="single">  
        <?php if (!dynamic_sidebar( 'single-sidebar' )) : ?>
        <?php endif; ?>
        </div>
    <?php else : ?>
        <div id="common">  
        <?php if (!dynamic_sidebar( 'common-sidebar' )) : ?>
        <?php endif; ?>
        </div>
    <?php endif; ?>

    </div>