<?php /*
	Block Name: Tertiary CTA
	Block Align: center
	Block Icon: megaphone
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group            = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$caption          = $group['caption'] ?? '';
		$heading          = $group['heading'] ?? '';
		$content          = $group['content'] ?? '';
		$media_type       = $group['media_type'] ?? 'none';
		$image            = $group['image'] ?? '';
		$has_background   = $group['has_background'] ?? true;
		$background_color = $group['background_color'] ?? 'light';
		$has_border_radius = $group['has_border_radius'] ?? true;
		$buttons_group = $group['buttons_group'] ?? [];

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
						'alt' => wp_strip_all_tags($heading ?? 'Tertiary CTA image')
					];
				}
			}
		}

		$classes = ['l-section', 'l-section--tertiary-cta', 'js-tertiary-cta'];
		$block_classes = ['tertiary-cta'];

		if ($has_background) {
			$block_classes[] = 'tertiary-cta--has-background';
			$block_classes[] = 'tertiary-cta--bg-' . $background_color;

			if ($background_color === 'dark') {
				$block_classes[] = 'is-dark';
			}
		}

		if ($has_border_radius) {
			$block_classes[] = 'tertiary-cta--has-radius';
		}

		if ($media_type === 'image') {
			$block_classes[] = 'tertiary-cta--has-image';
		}
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="tertiary-cta">
		<div class="l-wrapper">
			<div class="<?php echo esc_attr(implode(' ', $block_classes)); ?>">
				<div class="tertiary-cta__content">
					<?php if (!empty($caption)) : ?>
						<div class="tertiary-cta__caption">
							<?php echo esc_html($caption); ?>
						</div>
					<?php endif; ?>

					<?php if (!empty($heading)) : ?>
						<h2 class="tertiary-cta__heading">
							<?php echo $heading; ?>
						</h2>
					<?php endif; ?>

					<?php if (!empty($content)) : ?>
						<div class="tertiary-cta__body">
							<?php echo $content; ?>
						</div>
					<?php endif; ?>

					<?php
						get_acf_components([
							'buttons' => [
								'data'    => $buttons_group,
								'classes' => 'tertiary-cta__buttons',
							],
						]);
					?>
				</div>

				<?php if ($media_type === 'image' && !empty($image)) : ?>
					<div class="tertiary-cta__media">
						<?php
							if (!empty($image['id'])) {
								if (function_exists('bis_get_attachment_picture')) {
									echo bis_get_attachment_picture(
										$image['id'],
										[
											560  => [ 300, 300, 1 ],
											1024 => [ 300, 300, 1 ],
											2800 => [ 300 * 2, 300 * 2, 1 ],
										],
										[
											'alt'     => $image['alt'] ? $image['alt'] : wp_strip_all_tags($heading ?? ''),
											'class'   => 'tertiary-cta__image',
											'loading' => 'lazy',
										]
									);
								} else {
									$img_src = wp_get_attachment_image_url($image['id'], 'large');
									$img_alt = get_post_meta($image['id'], '_wp_attachment_image_alt', true) ?: wp_strip_all_tags($heading ?? '');
									echo '<img class="tertiary-cta__image" src="' . esc_url($img_src) . '" alt="' . esc_attr($img_alt) . '" loading="lazy" />';
								}
							} elseif (!empty($image['url'])) {
								echo '<img class="tertiary-cta__image" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt'] ?? '') . '" loading="lazy" />';
							}
						?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
