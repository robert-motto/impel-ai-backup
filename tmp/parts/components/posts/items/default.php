<?php
	$post_id = $args['post_id'];
	$classes = $args['classes'] ?? '';
	$has_description = $args['has_description'] ?? false;
	$has_reading_time = $args['has_reading_time'] ?? false;

	$post_type   = get_post_type($post_id);
	$title       = get_the_title($post_id);
	$date        = get_the_date('F d, Y', $post_id);
	$link_url    = get_the_permalink($post_id);
	$link_title  = __('Go to - ',  get_option('template')) . $title;
	$image       = [
		'id'  => get_post_thumbnail_id($post_id),
		'alt' => get_post_meta($post_id, '_wp_attachment_image_alt', true),
	];

	switch($post_type) {
		case 'custom':
			$category_taxonomy = 'custom_category';
			break;
		default:
			$category_taxonomy = 'category';
			break;
	}
	$primary_category = get_post_primary_category($post_id, $category_taxonomy);

?>
<article class="post-item <?php echo $classes; ?>">
	<a href="<?php echo $link_url; ?>" class="post-item__link" title="<?php echo $link_title; ?>">
		<?php
			if (has_post_thumbnail($post_id)) :
				echo bis_get_attachment_picture(
					get_post_thumbnail_id($post_id),
					[
						379 => [ 379,  220, 1 ],
						550 => [ 379 * 1.35,  220 * 1.35, 1 ],
						1920 => [ 379,  220, 1 ],
						2800 => [ 379 * 2, 220 * 2, 1 ],
					],
					[
						'alt' => $image['alt'] ? $image['alt'] : wp_strip_all_tags($title),
						'loading' => 'lazy',
						'class' => 'post-item__img',
					]
				);
			else :
		?>
			<div class="post-item__img post-item__img--placeholder">
				<?php get_icon('logo'); ?>
			</div>
		<?php endif; ?>
		<div class="post-item__content">
			<div class="post-item__meta">
				<?php if(!empty($primary_category)) : ?>
					<span class="post-item__category category-tag"><?php echo $primary_category['primary_category']->name; ?></span>
				<?php endif; ?>
				<?php if($has_reading_time) : ?>
					<div class="post-item__time ">
						<?php
							echo reading_time($post_id);
						?>
					</div>
				<?php endif; ?>
			</div>
			<span class="post-item__title "><?php echo $title; ?></span>
			<?php if($has_description) : ?>
				<p class="post-item__description"><?php echo get_the_excerpt($post_id); ?></p>
			<?php endif; ?>
			<span class="post-item__date "><?php echo $date; ?></span>
		</div>
	</a>
</article>
