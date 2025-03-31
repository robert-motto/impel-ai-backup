<?php /*
	Block Name: Hero
	Block Align: center
	Block Icon: superhero-alt
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group      = blockFieldGroup(__FILE__);
		$heading    = $group['heading_group'] ?? [];
		$subheading = $group['subheading_group'] ?? [];
		$buttons    = $group['buttons_group'] ?? [];
		$image      = $group['image'] ?? null;

		// Set fallback image if none is selected
		if (empty($image) || !isset($image['id'])) {
			$fallback_image_path = get_template_directory() . '/screenshot.jpg';
			$fallback_image_uri = get_template_directory_uri() . '/screenshot.jpg';

			if (file_exists($fallback_image_path)) {
				// Try to get the attachment ID if the image exists in the media library
				$fallback_attachment = attachment_url_to_postid($fallback_image_uri);

				if ($fallback_attachment) {
					$image = ['id' => $fallback_attachment];
				} else {
					// If not in media library, use the direct URI
					$image = [
						'url' => $fallback_image_uri,
						'alt' => wp_strip_all_tags($heading['title'] ?? 'Hero image')
					];
				}
			}
		}

		// Section classes
		$classes = ['l-section', 'l-section--hero'];
		if (!empty($group['section_settings_group']['background_color'])) {
			$classes[] = 'is-' . $group['section_settings_group']['background_color'];
		} else {
			$classes[] = 'is-light';
		}

		// JS class for potential animations
		$js_class = 'js-hero';
	?>
	<section class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-block="hero">
		<div class="l-wrapper">
			<div class="hero <?php echo $js_class; ?>">
				<div class="hero__text-hld">
					<?php
						get_acf_components([
							'heading' => [
								'data'    => $heading,
								'classes' => 'hero__heading',
							],
							'subheading' => [
								'data'    => $subheading,
								'classes' => 'hero__subheading',
							],
							'buttons' => [
								'data'    => $buttons,
								'classes' => 'hero__btns',
							],
						]);
					?>
				</div>
				<div class="hero__image-hld">
					<?php
						if (!empty($image['id'])) {
							// Use the attachment ID if available
							echo bis_get_attachment_picture(
								$image['id'],
								[
									560  => [ 390 * 2, 772 * 2, 1 ],
									1024 => [ 1024, 1474, 1 ],
									1365 => [ 1400, 760, 1 ],
									2800 => [ 1400 * 2, 760 * 2, 1 ],
								],
								[
									'alt'   => $image['alt'] ? $image['alt'] : wp_strip_all_tags($heading['title'] ?? ''),
									'class' => '',
								]
							);
						} elseif (!empty($image['url'])) {
							// Use the direct URL if no ID is available (fallback)
							echo '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" />';
						}
					?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
