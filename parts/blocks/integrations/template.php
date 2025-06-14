<?php /*
	Block Name: Integrations
	Block Align: center
	Block Icon: admin-plugins
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group           		= isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$layout_variant  		= $group['layout_variant'] ?? 'text-left';
		$color_mode      		= $group['section_settings_group']['mode'] ?? 'light';
		$color_mode_variant	= $group['mode_variant'] ?? 'primary';
		$caption         		= $group['caption'] ?? '';
		$heading         		= $group['heading'] ?? '';
		$content         		= $group['content'] ?? '';
		$buttons         		= $group['buttons_group'] ?? [];
		$media_type      		= $group['media_type'] ?? 'image';
		$image           		= $group['image'] ?? '';
		$video_group     		= $group['video_group'] ?? [];
		$media_disclaimer 	= $group['media_disclaimer'] ?? '';
		$show_divider    		= $group['show_divider'] ?? false;

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
						'alt' => wp_strip_all_tags($heading ?? 'Integrations image')
					];
				}
			}
		}

		// Section classes
		$classes = ['js-section', 'l-section', 'l-section--integrations', 'js-integrations', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}"];

		// Row classes for layout variants
		$row_classes = ['integrations', 'l-wrapper', 'l-wrapper--medium'];
		if ($layout_variant === 'text-right') {
			$row_classes[] = 'integrations--reverse';
		}
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="integrations" data-variant="<?php echo esc_attr($layout_variant); ?>">
		<div class="<?php echo esc_attr(implode(' ', $row_classes)); ?>">
			<div class="integrations__content-hld">
				<?php if (!empty($caption)) : ?>
					<div class="integrations__caption">
						<?php echo esc_html($caption); ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($heading)) : ?>
					<div class="integrations__heading">
						<?php echo $heading; ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($content)) : ?>
					<div class="integrations__body">
						<?php echo $content; ?>
					</div>
				<?php endif; ?>
				<?php
					get_acf_components([
						'buttons' => [
							'data'    => $buttons,
							'classes' => 'integrations__btns',
						],
					]);
				?>
				<?php if ($show_divider) : ?>
					<div class="integrations__divider"></div>
				<?php endif; ?>
			</div>
			<div class="integrations__media-hld">
				<?php if ($media_type === 'image') : ?>
					<?php
						if (!empty($image['id'])) {
							echo bis_get_attachment_picture(
								$image['id'],
								[
									560  => [ 560, 373, 1 ],
									1024 => [ 624, 680, 1 ],
									1920 => [ 624, 680, 1 ],
									2800 => [ 624 * 2, 680 * 2, 1 ],
								],
								[
									'alt'     => $image['alt'] ? $image['alt'] : wp_strip_all_tags($heading ?? ''),
									'class'   => 'integrations__img'
								],
							);
						} elseif (!empty($image['url'])) {
							echo '<img class="integrations__img" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '"  />';
						}
					?>
				<?php elseif ($media_type === 'video' && !empty($video_group)) : ?>
					<?php
						get_acf_components([
							'video' => [
								'data'    => $video_group,
								'classes' => 'integrations__video',
							]
						]);
					?>
				<?php endif; ?>
				<?php if (!empty($media_disclaimer)) : ?>
					<div class="integrations__media-disclaimer">
						<?php echo esc_html($media_disclaimer); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
