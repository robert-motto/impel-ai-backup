<?php /*
	Block Name: Grid of Items
	Block Align: center
	Block Icon: grid-view

	TODO:
	- Add slider variant
	- Add metrics
	- Add offices variant
*/ ?>
<?php if (isset($block['data']['is_preview'])) : ?>
	<?php block_preview(__FILE__); ?>
<?php else : ?>
	<?php
	$group           = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
	$color_mode      		= $group['section_settings_group']['mode'] ?? 'light';
	$color_mode_variant	= $group['mode_variant'] ?? 'regular';
	$heading         		= $group['heading_box_group'] ?? '';

	$item_style      = $group['item_style'] ?? 'with-icons';
	$grid_items      = $group['grid_items'] ?? [];
	$columns_count   = $group['columns_count'] ?? '3';

	// Section classes
	$classes = ['l-section', 'l-section--grid-of-items', 'js-grid-of-items', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}"];


	// // Grid item classes
	$grid_classes = ['grid-of-items__grid'];
	if ($item_style === 'with-icons') {
		$grid_classes[] = 'grid-of-items__grid--icons';
	} else {
		$grid_classes[] = 'grid-of-items__grid--images';
	}
	$grid_classes[] = 'grid-of-items__grid--cols-' . $columns_count;

	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-block="tabs">

		<div class="grid-of-items l-wrapper">
			<?php
			get_acf_component(
				'heading-box',
				[
					'data' => $heading,
				],
			);
			?>

			<div class="<?php echo esc_attr(implode(' ', $grid_classes)); ?>">
				<?php foreach ($grid_items as $item) : ?>
					<?php
					$item_heading = $item['item_heading'] ?? '';
					$item_content = $item['item_content'] ?? '';
					$item_link = $item['item_link'] ?? '';
					$media_type = $item['media_type'] ?? 'image';
					$image = $item['image'] ?? '';
					$svg_icon = $item['svg_icon'] ?? '';

					// Set fallback image if none is selected and media type is image
					if ($media_type === 'image' && (empty($image) || !isset($image['id']))) {
						$fallback_image_path = get_template_directory() . '/screenshot.jpg';
						$fallback_image_uri = get_template_directory_uri() . '/screenshot.jpg';
						if (file_exists($fallback_image_path)) {
							$fallback_attachment = attachment_url_to_postid($fallback_image_uri);
							if ($fallback_attachment) {
								$image = ['id' => $fallback_attachment];
							} else {
								$image = [
									'url' => $fallback_image_uri,
									'alt' => wp_strip_all_tags($item_heading ?? 'Grid item')
								];
							}
						}
					}
					?>

					<?php if (!empty($item_link)) : ?>
						<a href="<?php echo esc_url($item_link['url']); ?>"
							class="grid-of-items__item grid-of-items__item--link"
							<?php echo !empty($item_link['target']) ? 'target="' . esc_attr($item_link['target']) . '"' : ''; ?>
							aria-label="<?php echo esc_attr($item_link['title'] ?? $item_heading ?? 'Grid item link'); ?>">
						<?php else : ?>
							<div class="grid-of-items__item">
							<?php endif; ?>
							<div class="grid-of-items__media-container">
								<?php if ($item_style === 'with-images' && !empty($image)) : ?>
									<?php
									if (!empty($image['id'])) {
										echo bis_get_attachment_picture(
											$image['id'],
											[
												560  => [560, 373, 1],
												1024 => [720, 480, 1],
												1920 => [720, 480, 1],
												2800 => [720 * 2, 480 * 2, 1],
											],
											[
												'alt'     => $image['alt'] ? $image['alt'] : wp_strip_all_tags($item_heading ?? 'Grid item'),
												'class'   => 'grid-of-items__img',
												'loading' => 'lazy',
											],
										);
									} elseif (!empty($image['url'])) {
										echo '<img class="grid-of-items__img" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt'] ?? 'Grid item') . '" loading="lazy" />';
									}
									?>
								<?php elseif ($item_style === 'with-icons' && !empty($svg_icon)) : ?>
									<?php
									if (!empty($svg_icon['id'])) {
										echo wp_get_attachment_image(
											$svg_icon['id'],
											'full',
											false,
											[
												'class' => 'grid-of-items__svg',
												'loading' => 'lazy',
											]
										);
									} elseif (!empty($svg_icon['url'])) {
										echo '<img class="grid-of-items__svg" src="' . esc_url($svg_icon['url']) . '" alt="' . esc_attr($svg_icon['alt'] ?? 'SVG icon') . '" loading="lazy" />';
									}
									?>
								<?php endif; ?>
							</div>
							<div class="grid-of-items__content">

								<?php if (!empty($item_heading)) : ?>
									<div class="grid-of-items__item-heading">
										<?php echo $item_heading; ?>
									</div>
								<?php endif; ?>

								<?php if (!empty($item_content)) : ?>
									<div class="grid-of-items__item-content">
										<?php echo $item_content; ?>
									</div>
								<?php endif; ?>

								<?php if (!empty($item_link)) : ?>
									<div class="grid-of-items__item-link">
										<?php get_acf_component('button', [
											'data' => array(
												'type' => 'link',
												'size' => 'regular',
												'has_icon' => 'y',
												'button' => array(
													'url' => $item_link['url'],
													'title' => $item_link['title'],
													'target' => $item_link['target'],
												),
											),
											'tag' => 'div',
										]); ?>
									</div>
								<?php endif; ?>
							</div>
							<?php if (!empty($item_link)) : ?>
						</a>
					<?php else : ?>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
		</div>
		</div>
	</section>
<?php endif; ?>