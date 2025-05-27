<?php /*
	Block Name: Grid of Items
	Block Align: center
	Block Icon: grid-view
*/ ?>
<?php if (isset($block['data']['is_preview'])) : ?>
	<?php block_preview(__FILE__); ?>
<?php else : ?>
	<?php
	$group           = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
	$caption         = $group['caption'] ?? '';
	$heading         = $group['heading'] ?? '';
	$content         = $group['content'] ?? '';
	$buttons         = $group['buttons_group'] ?? [];
	$item_style      = $group['item_style'] ?? 'with-icons';
	$grid_items      = $group['grid_items'] ?? [];
	$columns_count   = $group['columns_count'] ?? '3';
	$has_background  = $group['has_background'] ?? false;
	$background_color = $group['background_color'] ?? 'light';

	// Ensure we have at least 1 grid item
	if (empty($grid_items)) {
		$grid_items = [
			[
				'badge_label' => 'Label',
				'item_heading' => 'Item heading goes here',
				'item_content' => 'Item content goes here',
				'media_type' => 'image',
			],
			[
				'badge_label' => 'Label',
				'item_heading' => 'Item heading goes here',
				'item_content' => 'Item content goes here',
				'media_type' => 'image',
			],
			[
				'badge_label' => 'Label',
				'item_heading' => 'Item heading goes here',
				'item_content' => 'Item content goes here',
				'media_type' => 'image',
			]
		];
	}

	// Section classes
	$classes = ['js-section', 'l-section', 'l-section--grid-of-items', 'js-grid-of-items'];
	if ($has_background) {
		$classes[] = 'is-' . $background_color;
	}

	// Grid item classes
	$grid_classes = ['grid-of-items__grid'];
	if ($item_style === 'with-icons') {
		$grid_classes[] = 'grid-of-items__grid--icons';
	} else {
		$grid_classes[] = 'grid-of-items__grid--images';
	}
	$grid_classes[] = 'grid-of-items__grid--cols-' . $columns_count;
	?>
		<div class="grid-of-items l-wrapper">
			<?php if (!empty($caption) || !empty($heading) || !empty($content)) : ?>
				<div class="grid-of-items__header">
					<?php if (!empty($caption)) : ?>
						<div class="grid-of-items__caption">
							<?php echo esc_html($caption); ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($heading)) : ?>
						<div class="grid-of-items__heading">
							<?php echo $heading; ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($content)) : ?>
						<div class="grid-of-items__body">
							<?php echo $content; ?>
						</div>
					<?php endif; ?>
					<?php
					get_acf_components([
						'buttons' => [
							'data'    => $buttons,
							'classes' => 'grid-of-items__btns',
						],
					]);
					?>
				</div>
			<?php endif; ?>

		<div class="<?php echo esc_attr(implode(' ', $grid_classes)); ?>">
			<?php foreach ($grid_items as $item) : ?>
				<?php
				$badge_label = $item['badge_label'] ?? '';
				$item_heading = $item['item_heading'] ?? '';
				$item_content = $item['item_content'] ?? '';
				$item_buttons = $item['item_buttons_group'] ?? [];
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

				<div class="grid-of-items__item">
					<div class="grid-of-items__media-container">
						<?php if ($media_type === 'image' && !empty($image)) : ?>
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
						<?php elseif ($media_type === 'svg' && !empty($svg_icon)) : ?>
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
						<?php if (!empty($badge_label)) : ?>
							<div class="grid-of-items__badge">
								<?php echo esc_html($badge_label); ?>
							</div>
						<?php endif; ?>

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

						<?php
						get_acf_components([
							'buttons' => [
								'data'    => $item_buttons,
								'classes' => 'grid-of-items__item-btns',
							],
						]);
						?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	</section>
<?php endif; ?>
