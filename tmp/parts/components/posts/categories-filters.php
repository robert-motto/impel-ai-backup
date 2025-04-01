<?php
	$categories        = $args['categories'];
	$current_cat_slug  = $args['current_cat_slug'];
	$current_object    = $args['current_object'];
	$categories_label  = $args['categories_label'];
	$all_filters_label = $args['all_filters_label'];
	$all_posts_link    = $args['all_posts_link'];
	$search_phrase     = $args['search_phrase'];
	$current_tag_slug  = $args['current_tag_slug'];
	$order_by          = $args['order_by'];

	$params  = !empty($current_tag_slug) ? '?topic='.$current_tag_slug : '';
	$mark    = !empty($current_tag_slug) ? '&' : '?';
	$params .= !empty($search_phrase) ? $mark.'search='.$search_phrase : '';
	$mark2   = str_contains($params, '?') ? '&' : '?';
	$params .= (!empty($order_by) ? $mark2.'order_by='.$order_by : '');

	if(!empty($categories)):
?>
	<div class="post-listing__filters-hld">
		<input type="checkbox" id="show-categories" hidden>
		<span class="post-listing__filters-label"> <?php echo $categories_label; ?></span>
		<label for="show-categories" class="post-listing__filters-mobile-btn btn btn--secondary">
			<span class="text">
				<?php echo empty($current_cat_slug) ? $all_filters_label  : $current_object->post_title; ?>
			</span>
			<?php
				get_icon('chevron-down', [
					'classes' => 'post-listing__filters-mobile-btn__icon',
				]);
			?>
		</label>
		<div class="post-listing__filters">
			<div>
				<div>
					<a class="post-listing__filters__item js-filter-item <?php echo empty($current_cat_slug) ? 'is-active' : ''; ?>" href="<?php echo $all_posts_link; ?>" title="<?php _e('See all posts', 'motto-theme'); ?>">
						<?php echo $all_filters_label; ?>
					</a>
					<?php foreach($categories as $category) : ?>
						<a class="post-listing__filters__item js-filter-item <?php echo $current_cat_slug === $category->slug ? 'is-active' : '';?>" href="<?php echo get_term_link($category->term_id).''.$params; ?>" title="<?php echo __('See posts form category - ', 'motto-theme').$category->name;?>">
							<?php echo $category->name; ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
