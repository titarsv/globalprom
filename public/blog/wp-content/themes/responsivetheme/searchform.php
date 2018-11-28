<form name="search" action="<?php echo home_url( '/' ) ?>" method="get" class="search-form">
	<div class="form-group">
		<input type="text" value="<?php echo get_search_query() ?>" name="s" placeholder="<?php echo __('Search', 'whitesquare'); ?>" class="form-control">
	</div>
<!-- 		<button type="submit" class="btn btn-primary"><?php //echo __('GO', 'whitesquare'); ?></button>
 --></form>