<?php /*
	Block Name: Single Media Section
	Block Align: center
	Block Icon: format-image
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group           = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$alignment       = $group['alignment'] ?? 'center';
		$caption         = $group['caption'] ?? '';
		$heading         = $group['heading'] ?? '';
		$content         = $group['content'] ?? '';
		$buttons         = $group['buttons_group'] ?? [];
		$media_type      = $group['media_type'] ?? 'image';
		$image           = $group['image'] ?? '';
		$video_group     = $group['video_group'] ?? [];
		$media_caption   = $group['media_caption'] ?? '';
		$has_background  = $group['has_background'] ?? false;
		$background_color = $group['background_color'] ?? 'light';

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
						'alt' => wp_strip_all_tags($heading ?? 'Single media section image')
					];
				}
			}
		}

		// Section classes
		$classes = ['js-section', 'l-section', 'l-section--single-media', 'js-single-media'];
		if ($has_background) {
			$classes[] = 'is-' . $background_color;
		}

		// Content classes based on alignment
		$content_classes = ['single-media__content'];
		if ($alignment === 'left') {
			$content_classes[] = 'single-media__content--left';
		}
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="single-media" data-alignment="<?php echo esc_attr($alignment); ?>">
		<div class="l-wrapper">
			<div class="single-media">
				<div class="<?php echo esc_attr(implode(' ', $content_classes)); ?>">
					<?php if (!empty($caption)) : ?>
						<div class="single-media__caption">
							<?php echo esc_html($caption); ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($heading)) : ?>
						<div class="single-media__heading">
							<?php echo $heading; ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($content)) : ?>
						<div class="single-media__body">
							<?php echo $content; ?>
						</div>
					<?php endif; ?>
					<?php
						get_acf_components([
							'buttons' => [
								'data'    => $buttons,
								'classes' => 'single-media__btns',
							],
						]);
					?>
				</div>
				<div class="single-media__media-hld">
					<?php if ($media_type === 'image') : ?>
						<?php
							if (!empty($image['id'])) {
								echo bis_get_attachment_picture(
									$image['id'],
									[
										560  => [ 560, 315, 1 ],
										1024 => [ 1040, 580, 1 ],
										1920 => [ 1040, 580, 1 ],
										2800 => [ 1040 * 2, 580 * 2, 1 ],
									],
									[
										'alt'     => $image['alt'] ? $image['alt'] : wp_strip_all_tags($heading ?? ''),
										'class'   => 'single-media__img',
										'loading' => 'lazy',
									],
								);
							} elseif (!empty($image['url'])) {
								echo '<img class="single-media__img" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" loading="lazy" />';
							}
						?>
					<?php elseif ($media_type === 'video' && !empty($video_group)) : ?>
						<?php
							get_acf_components([
								'video' => [
									'data'    => $video_group,
									'classes' => 'single-media__video',
								]
							]);
						?>
					<?php endif; ?>
					<?php if (!empty($media_caption)) : ?>
						<div class="single-media__media-caption">
							<?php echo esc_html($media_caption); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
