<div class="sidebar">
	<h3 class="screen-reader-text">Sidebar Content</h3>
	<?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
	<div class="primary-sidebar">
		<?php dynamic_sidebar( 'primary-sidebar' ); ?>
	</div>
	<?php endif; ?>
</div>