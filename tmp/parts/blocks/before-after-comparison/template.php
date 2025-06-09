<?php /*
	Block Name: Before & After Comparison
	Block Align: center
	Block Icon: format-gallery
*/ ?>
<?php if (isset($block['data']['is_preview'])) : ?>
	<?php block_preview(__FILE__); ?>
<?php else : ?>
	<?php
	$group            	= isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
	$color_mode      		= $group['section_settings_group']['mode'] ?? 'light';
	$color_mode_variant	= $group['mode_variant'] ?? 'regular';
	$image_position			= $group['image_position'] ?? 'center';
	$heading        		= $group['heading_box_group'] ?? '';
	$buttons        		= $group['action_group_group'] ?? [];
	$comparison_images 	= $group['comparison_images'] ?? [];
	$before_image     	= $comparison_images['before_image'] ?? '';
	$after_image      	= $comparison_images['after_image'] ?? '';
	$before_button_text = $comparison_images['before_button_text'] ?? 'Before';
	$after_button_text 	= $comparison_images['after_button_text'] ?? 'After';

	// Set fallback images if none are selected
	$fallback_image_path = get_template_directory() . '/screenshot.jpg';
	$fallback_image_uri = get_template_directory_uri() . '/screenshot.jpg';

	if (empty($before_image) || !isset($before_image['id'])) {
		if (file_exists($fallback_image_path)) {
			$fallback_attachment = attachment_url_to_postid($fallback_image_uri);
			if ($fallback_attachment) {
				$before_image = ['id' => $fallback_attachment];
			} else {
				$before_image = [
					'url' => $fallback_image_uri,
					'alt' => wp_strip_all_tags($heading ?? 'Before image')
				];
			}
		}
	}

	if (empty($after_image) || !isset($after_image['id'])) {
		if (file_exists($fallback_image_path)) {
			$fallback_attachment = attachment_url_to_postid($fallback_image_uri);
			if ($fallback_attachment) {
				$after_image = ['id' => $fallback_attachment];
			} else {
				$after_image = [
					'url' => $fallback_image_uri,
					'alt' => wp_strip_all_tags($heading ?? 'After image')
				];
			}
		}
	}

	// Section classes
	$classes = ['js-section', 'l-section',  'l-section--before-after-comparison', 'js-before-after-comparison', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}", "image-position-{$image_position}"];

	// Unique ID for this comparison instance
	$unique_id = uniqid('comparison-');
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> data-block=" before-after-comparison">
		<div class="before-after-comparison l-wrapper">
			<div class="before-after-comparison__content">
				<?php
				get_acf_component(
					'heading-box',
					[
						'data' => $heading,
					],
				);
				?>
				<?php if ($image_position !== 'center'):
					get_acf_component(
						'action-group',
						[
							'data' => $buttons,
							'classes' => 'before-after-comparison__content-btns',
						],
					);
				endif; ?>
			</div>

			<div class="before-after-comparison__image-outer-container">



				<div class="before-after-comparison__controls">
					<button class="before-after-comparison__btn before-after-comparison__btn--before is-active" data-comparison-id="<?php echo esc_attr($unique_id); ?>" data-state="before">
						<?php echo esc_html($before_button_text); ?>
					</button>
					<button class="before-after-comparison__btn before-after-comparison__btn--after" data-comparison-id="<?php echo esc_attr($unique_id); ?>" data-state="after">
						<?php echo esc_html($after_button_text); ?>
					</button>
				</div>

				<div class="before-after-comparison__image-container js-before-after-container" id="<?php echo esc_attr($unique_id); ?>">
					<div class="before-after-comparison__before-wrapper js-before-wrapper">
						<?php
						if (!empty($before_image['id'])) {
							echo bis_get_attachment_picture(
								$before_image['id'],
								[
									560  => [560, 292, 1],
									1024 => [976, 508, 1],
									1920 => [976, 508, 1],
									2800 => [1952, 1016, 1],
								],
								[
									'alt'     => $before_image['alt'] ? $before_image['alt'] : wp_strip_all_tags($heading ?? 'Before image'),
									'class'   => 'before-after-comparison__img before-after-comparison__img--before'
								],
							);
						} elseif (!empty($before_image['url'])) {
							echo '<img class="before-after-comparison__img before-after-comparison__img--before" src="' . esc_url($before_image['url']) . '" alt="' . esc_attr($before_image['alt']) . '"  />';
						}
						?>
					</div>

					<div class="before-after-comparison__after-wrapper js-after-wrapper">
						<?php
						if (!empty($after_image['id'])) {
							echo bis_get_attachment_picture(
								$after_image['id'],
								[
									560  => [560, 292, 1],
									1024 => [976, 508, 1],
									1920 => [976, 508, 1],
									2800 => [1952, 1016, 1],
								],
								[
									'alt'     => $after_image['alt'] ? $after_image['alt'] : wp_strip_all_tags($heading ?? 'After image'),
									'class'   => 'before-after-comparison__img before-after-comparison__img--after'
								],
							);
						} elseif (!empty($after_image['url'])) {
							echo '<img class="before-after-comparison__img before-after-comparison__img--after" src="' . esc_url($after_image['url']) . '" alt="' . esc_attr($after_image['alt']) . '"  />';
						}
						?>
					</div>

					<div class="before-after-comparison__slider js-comparison-slider">
						<div class="before-after-comparison__slider-line"></div>
						<div class="before-after-comparison__slider-handle">
							<div class="before-after-comparison__slider-handle-icon">
								<?php get_icon('chevron-left'); ?>
							</div>
							<div class="before-after-comparison__slider-handle-icon">
								<?php get_icon('chevron-right'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
			get_acf_component(
				'action-group',
				[
					'data' => $buttons,
					'classes' => 'before-after-comparison__btns',
				],
			);
			?>
		</div>

	</section>
<?php endif; ?>