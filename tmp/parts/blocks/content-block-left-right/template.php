<?php /*
	Block Name: Content Block Left/Right
	Block Align: center
	Block Icon: format-aside
*/ ?>
<?php if (isset($block['data']['is_preview'])) : ?>
	<?php block_preview(__FILE__); ?>
<?php else : ?>
	<?php
	$group           		= isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
	$layout_variant  		= $group['layout_variant'] ?? 'text-left';
	$color_mode      		= $group['section_settings_group']['mode'] ?? 'light';
	$color_mode_variant	= $group['mode_variant'] ?? 'regular';
	$heading         		= $group['heading_box_group'] ?? '';
	$text         			= $group['text'] ?? '';
	$buttons 						= $group['action_group_group'] ?? [];
	$media_type     		= $group['media_type'] ?? 'image';
	$image           		= $group['image'] ?? '';
	$video_group     		= $group['video_group'] ?? [];
	$image_display_size = $group['image_display_size'] ?? 'regular';
	$show_metric        = $group['show_metric'] ?? 0;
	$metric_icon        = $group['metric_icon'] ?? 'arrow-up';
	$metric_text        = $group['metric_text'] ?? '';

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
					'alt' => wp_strip_all_tags((is_array($heading) && isset($heading['heading']) && is_string($heading['heading'])) ? $heading['heading'] : 'Content block image')
				];
			}
		}
	}

	// Section classes
	$classes = ['js-section', 'l-section', 'l-section--content-block', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}",];

	// Row classes for layout variants
	$row_classes = ['content-block', 'l-wrapper'];
	if ($layout_variant === 'text-right') {
		$row_classes[] = 'content-block--reverse';
	}

	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-block="content-block" data-variant="<?php echo esc_attr($layout_variant); ?>">
		<div class="<?php echo esc_attr(implode(' ', $row_classes)); ?>">
			<div class="content-block__content-hld">
				<?php
				get_acf_component(
					'heading-box',
					[
						'data' => array_merge($heading, ['alignment' => 'left']),
					],
				);
				?>
				<?php if (!empty($text)) : ?>
					<div class="content-block__text">
						<?php echo $text; ?>
					</div>
				<?php endif; ?>
				<?php
				get_acf_component(
					'action-group',
					[
						'data' => $buttons,
						'classes' => 'content-block__btns',
					],
				);
				?>
			</div>
			<?php
			$media_hld_classes = ['content-block__media-hld'];
			if ($media_type === 'image' && $image_display_size === 'small') {
				$media_hld_classes[] = 'content-block__media-hld--small';
			}
			?>
			<div class="<?php echo esc_attr(implode(' ', $media_hld_classes)); ?>">
				<?php if ($media_type === 'image') : ?>
					<?php
					if (!empty($image['id'])) {
						echo bis_get_attachment_picture(
							$image['id'],
							[
								560  => [560, 560, 1],
								1024 => [564, 634, 1],
								1920 => [564, 634, 1],
								2800 => [564 * 2, 634 * 2, 1],
							],
							[
								'alt'     => $image['alt'] ? $image['alt'] : wp_strip_all_tags((is_array($heading) && isset($heading['heading']) && is_string($heading['heading'])) ? $heading['heading'] : ''),
								'class'   => 'content-block__img',
								'loading' => 'lazy',
							],
						);
					} elseif (!empty($image['url'])) {
						echo '<img class="content-block__img" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '"  />';
					}
					?>
				<?php elseif ($media_type === 'video' && !empty($video_group)) : ?>
					<?php
					get_acf_components([
						'video' => [
							'data'    => $video_group,
							'classes' => 'content-block__video',
						]
					]);
					?>
				<?php endif; ?>

				<?php if ($show_metric) : ?>
					<div class="content-block__metric">
						<div class="content-block__metric-icon">
							<?php
							$icon_name = 'check';
							if ($metric_icon === 'arrow-up') {
								$icon_name = 'arrow-up-right';
							} elseif ($metric_icon === 'arrow-down') {
								$icon_name = 'arrow-down-right';
							}
							get_icon($icon_name);
							?>
						</div>
						<div class="content-block__metric-text">
							<?php echo esc_html($metric_text); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>