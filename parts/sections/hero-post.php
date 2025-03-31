
<?php
	$post_id = get_the_ID();
	$mode    = get_field('mode') ?? 'is-dark';

	$title        = get_the_title($post_id) ?? '';
	$title_size   = get_field('title_size') ?? 'h3';
	$title_weight = get_field('title_weight') ?? 'regular';
	$heading      = [
		'has_caption'  => 'n',
		'title_size'   => $title_size,
		'title_weight' => $title_weight,
		'title'        => $title,
	];

	$post_type    = get_post_type($post_id);
	$publish_date = get_the_date('F d, Y', $post_id);
	$image        = [
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

	$written_by  = empty(get_field('written_by')) ? get_the_author_meta('display_name', get_post_field('post_author', $post_id)) : get_field('written_by');
	$edited_by   = get_field('edited_by') ?? '';
	$reviewed_by = get_field('reviewed_by') ?? '';
?>
<section class="l-section l-section--hero-post <?php echo $mode; ?>">
	<div class="hero-post l-wrapper">
		<?php
			get_component('breadcrumbs', [
				'classes' => 'hero-post__breadcrumbs',
			]);
		?>
		<div class="hero-post__content-hld">
			<div class="hero-post__content">
				<div class="post-item__meta">
					<?php if(!empty($primary_category)) : ?>
						<span class="post-item__category category-tag t-caption t-caption--2"><?php echo $primary_category['primary_category']->name; ?></span>
					<?php endif; ?>
					<div class="post-item__time t-paragraph t-paragraph--4">
						<?php
							echo reading_time($post_id);
						?>
					</div>
				</div>
				<?php
					get_acf_component('heading', [
						'data' => $heading,
						'classes' => 'hero-post__heading',
					]);
				?>
				<div class="hero-post__desc">
					<div class="hero-post__desc__item">
						<span class="hero-post__desc__item__label t-caption t-caption--2"><?php _e('Written By', get_option('template')); ?></span>
						<span class="hero-post__desc__item__value t-paragraph t-paragraph--4"><?php echo $written_by; ?></span>
					</div>
					<?php if(!empty($edited_by)) : ?>
						<div class="hero-post__desc__item">
							<span class="hero-post__desc__item__label t-caption t-caption--2"><?php _e('Edited By', get_option('template')); ?></span>
							<span class="hero-post__desc__item__value t-paragraph t-paragraph--4"><?php echo $edited_by; ?></span>
						</div>
					<?php endif;?>
					<?php if(!empty($reviewed_by)) : ?>
						<div class="hero-post__desc__item">
							<span class="hero-post__desc__item__label t-caption t-caption--2"><?php _e('Reviewed By', get_option('template')); ?></span>
							<span class="hero-post__desc__item__value t-paragraph t-paragraph--4"><?php echo $reviewed_by; ?></span>
						</div>
					<?php endif;?>
					<div class="hero-post__desc__item">
						<span class="hero-post__desc__item__label t-caption t-caption--2"><?php _e('Published', get_option('template')); ?></span>
						<span class="hero-post__desc__item__value t-paragraph t-paragraph--4"><?php echo $publish_date; ?></span>
					</div>
				</div>
			</div>
			<?php
				if($image['id']) {
					echo bis_get_attachment_picture(
						$image['id'],
						[
							510  => [ 510 , 300 , 0 ],
							767  => [ 510 * 1.5, 300 * 1.5, 0 ],
							1920 => [ 510, 478, 0 ],
							2800 => [ 510 * 2, 478 * 2, 0 ],
						],
						[
							'alt'   => $image['alt'] ? $image['alt'] : wp_strip_all_tags($title),
							'class' => 'hero-post__img',
						]
					);
				}
			?>
		</div>
	</div>
</section>
