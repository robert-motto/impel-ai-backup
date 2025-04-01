<?php
	$tags               = $args['tags'];
	$tags_taxonomy_slug = $args['tags_taxonomy_slug'];
	$current_tag_slug   = $args['current_tag_slug'];
	$tags_label         = $args['tags_label'];
	$all_filters_label  = $args['all_filters_label'];
	$search_phrase      = $args['search_phrase'];
	$base_url           = $args['base_url'];
	$order_by           = $args['order_by'];

	$current_object = get_term_by('slug', $current_tag_slug, $tags_taxonomy_slug);

	$params  = !empty($search_phrase) ? '&search='.$search_phrase : '';
	$params .= (!empty($order_by) ? '&order_by='.$order_by : '');
	if(!empty($tags)):
?>
	<div class="post-listing__filters-hld">
		<input type="checkbox" id="show-tags" hidden>
		<span class="post-listing__filters-label"> <?php echo $tags_label; ?></span>
		<label for="show-tags" class="post-listing__filters-mobile-btn btn btn--secondary">
			<span class="text">
				<?php echo empty($current_tag_slug) ? $all_filters_label  : $current_object->name; ?>
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
					<a class="post-listing__filters__item js-filter-item <?php echo empty($current_tag_slug) ? 'is-active' : ''; ?>" href="<?php echo $base_url; ?>" title="<?php _e('See posts with all tags', 'motto-theme'); ?>">
						<?php echo $all_filters_label; ?>
					</a>
					<?php foreach($tags as $tag) : ?>
						<a class="post-listing__filters__item js-filter-item <?php echo $current_tag_slug === $tag->slug ? 'is-active' : '';?>" href="<?php echo $base_url.''.'?topic='.$tag->slug.''.$params; ?>" title="<?php echo __('See posts with tag - ', 'motto-theme').$tag->name;?>">
							<?php echo $tag->name; ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
