<?php /*
	Block Name: Secondary CTA
	Block Align: center
	Block Icon: megaphone
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$caption = $group['caption'] ?? '';
		$heading = $group['heading'] ?? '';
		$content = $group['content'] ?? '';
		$buttons = $group['buttons_group'] ?? [];
		$media_type = $group['media_type'] ?? 'image';
		$image = $group['image'] ?? '';
		$video_group = $group['video_group'] ?? [];
		$media_disclaimer = $group['media_disclaimer'] ?? '';
		$has_background = $group['has_background'] ?? true;
		$background_color = $group['background_color'] ?? 'light';
		$has_border_radius = $group['has_border_radius'] ?? true;

		// Set fallback image if none is selected
		if (empty($image) || !isset($image['id'])) {
			$fallback_image_path = get_template_directory() . '/screenshot.jpg';
			$fallback_image_uri = get_template_directory_uri() . '/screenshot.jpg';
			if (file_exists($fallback_image_path)) {
				$fallback_attachment = attachment_url_to_postid($fallback_image_uri);
				if ($fallback_attachment) {
					$image = ['id' => $fallback_attachment];
				} else {
					$image = [
						'url' => $fallback_image_uri,
						'alt' => 'Default image'
					];
				}
			}
		}

		// Section classes
		$classes = ['js-section', 'l-section', 'l-section--secondary-cta', 'js-secondary-cta'];
		if ($has_background) {
			$classes[] = 'is-' . $background_color;
		}
		if ($has_border_radius) {
			$classes[] = 'has-radius';
		}
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="secondary-cta">
		<div class="l-wrapper">
			<div class="secondary-cta">
				<div class="secondary-cta__media">
					<?php if ($media_type === 'image' && !empty($image)) : ?>
						<div class="secondary-cta__media-holder">
							<?php if (!empty($image['id'])) : ?>
								<?php echo wp_get_attachment_image(
									$image['id'],
									'large',
									false,
									[
										'class' => 'secondary-cta__image'
									]
								); ?>
							<?php elseif (!empty($image['url'])) : ?>
								<img class="secondary-cta__image" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?? 'Image'); ?>"  />
							<?php endif; ?>
						</div>
					<?php elseif ($media_type === 'video' && !empty($video_group)) : ?>
						<div class="secondary-cta__media-holder">
							<?php
								get_acf_components([
									'video' => [
										'data' => $video_group,
									],
								]);
							?>
						</div>
					<?php endif; ?>

					<?php if (!empty($media_disclaimer)) : ?>
						<div class="secondary-cta__media-disclaimer">
							<?php echo esc_html($media_disclaimer); ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="secondary-cta__content">
					<?php if (!empty($caption)) : ?>
						<div class="secondary-cta__caption">
							<?php echo esc_html($caption); ?>
						</div>
					<?php endif; ?>

					<?php if (!empty($heading)) : ?>
						<div class="secondary-cta__heading">
							<?php echo $heading; ?>
						</div>
					<?php endif; ?>

					<?php if (!empty($content)) : ?>
						<div class="secondary-cta__body">
							<?php echo $content; ?>
						</div>
					<?php endif; ?>

					<?php
						get_acf_components([
							'buttons' => [
								'data'    => $buttons,
								'classes' => 'secondary-cta__btns',
							],
						]);
					?>
				</div>

			</div>
		</div>
	</section>
<?php endif; ?>
