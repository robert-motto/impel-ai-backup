<?php
	$classes = isset($args['classes']) ? $args['classes'] : '';
	$search_label = isset($args['search_label']) ? $args['search_label'] : '';
	$search_phrase = isset($_GET['search']) ? $_GET['search'] : '';
?>
<form class="post-listing__search js-search <?php echo $classes;?>" action="<?php echo get_the_permalink();?>" method="get">
	<input class="post-listing__search__input js-search-input" type="text" name="search" value="<?php echo $search_phrase; ?>" placeholder="<?php echo $search_label;?>">
	<button class="post-listing__search__btn search-btn js-search-btn" type="submit">
		<span class="u-sr-only"><?php echo $search_label;?></span>
		<?php
			get_icon('search', [
				'classes' => 'post-listing__search__btn__icon',
			]);
		?>
	</button>
</form>
