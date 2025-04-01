<?php /*
	Block Name: Content Block Left/Right
	Block Align: center
	Block Icon: format-aside
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group           = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$layout_variant  = $group['layout_variant'] ?? 'text-left';
		$caption         = $group['caption'] ?? '';
		$heading         = $group['heading'] ?? '';
		$content         = $group['content'] ?? '';
		$buttons         = $group['buttons_group'] ?? [];
		$media_type      = $group['media_type'] ?? 'image';
		$image           = $group['image'] ?? '';
		$video_group     = $group['video_group'] ?? [];
		$media_disclaimer = $group['media_disclaimer'] ?? '';
		$show_divider    = $group['show_divider'] ?? false;
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
						'alt' => wp_strip_all_tags($heading ?? 'Content block image')
					];
				}
			}
		}

		// Section classes
		$classes = ['l-section', 'l-section--content-block', 'js-content-block'];
		if ($has_background) {
			$classes[] = 'is-' . $background_color;
		}

		// Row classes for layout variants
		$row_classes = ['content-block', 'l-wrapper'];
		if ($layout_variant === 'text-right') {
			$row_classes[] = 'content-block--reverse';
		}
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="content-block" data-variant="<?php echo esc_attr($layout_variant); ?>">
		<div class="<?php echo esc_attr(implode(' ', $row_classes)); ?>">
			<div class="content-block__content-hld">
				<?php if (!empty($caption)) : ?>
					<div class="content-block__caption">
						<?php echo esc_html($caption); ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($heading)) : ?>
					<div class="content-block__heading">
						<?php echo $heading; ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($content)) : ?>
					<div class="content-block__body">
						<?php echo $content; ?>
					</div>
				<?php endif; ?>
				<?php
					get_acf_components([
						'buttons' => [
							'data'    => $buttons,
							'classes' => 'content-block__btns',
						],
					]);
				?>
				<?php if ($show_divider) : ?>
					<div class="content-block__divider"></div>
				<?php endif; ?>
			</div>
			<div class="content-block__media-hld">
				<?php if ($media_type === 'image') : ?>
					<?php
						if (!empty($image['id'])) {
							echo bis_get_attachment_picture(
								$image['id'],
								[
									560  => [ 560, 373, 1 ],
									1024 => [ 720, 480, 1 ],
									1920 => [ 720, 480, 1 ],
									2800 => [ 720 * 2, 480 * 2, 1 ],
								],
								[
									'alt'     => $image['alt'] ? $image['alt'] : wp_strip_all_tags($heading ?? ''),
									'class'   => 'content-block__img',
									'loading' => 'lazy',
								],
							);
						} elseif (!empty($image['url'])) {
							echo '<img class="content-block__img" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" loading="lazy" />';
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
				<?php if (!empty($media_disclaimer)) : ?>
					<div class="content-block__media-disclaimer">
						<?php echo esc_html($media_disclaimer); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
