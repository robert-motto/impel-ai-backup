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
	$heading         = $group['heading_box_group'] ?? '';
	$media_type      = $group['media_type'] ?? 'image';
	$image           = $group['image'] ?? '';
	$video_group     = $group['video_group'] ?? [];
	$media_caption   = $group['media_caption'] ?? '';
	$color_mode      = $group['section_settings_group']['mode'] ?? 'light';
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
					'alt' => 'Single media section image'
				];
			}
		}
	}
	// Section classes
	$classes = ['js-section', 'l-section', 'l-section--single-media', 'js-single-media', "color-mode-{$color_mode}"];
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="single-media">
		<div class="single-media l-wrapper">
			<?php
				get_acf_component(
					'heading-box',
					[
						'data' => $heading,
					],
				);
			?>
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
									'class'   => 'single-media__img'
								],
							);
						} elseif (!empty($image['url'])) {
							echo '<img class="single-media__img" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '"  />';
						}
					?>
				<?php elseif ($media_type === 'video' && !empty($video_group)) : ?>
					<?php
						get_acf_component('video', [
							'data'    => $video_group,
							'classes' => 'single-media__video',
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
	</section>
<?php endif; ?>
