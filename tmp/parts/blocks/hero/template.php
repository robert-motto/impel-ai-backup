<?php /*
	Block Name: Hero
	Block Align: center
	Block Icon: superhero-alt
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group       = blockFieldGroup(__FILE__);
		$heading     = $group['heading'] ?? '';
		$subheading  = $group['subheading'] ?? '';
		$buttons     = $group['buttons_group'] ?? [];
		$media_type  = $group['media_type'] ?? 'image'; // Default to image
		$image       = $group['image'] ?? null;
		$video_group = $group['video_group'] ?? []; // Get video data if type is video

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
						'alt' => wp_strip_all_tags($heading ?? 'Hero image')
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
	<section class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group);?>" data-block="hero">
		<div class="l-wrapper">
			<div class="hero <?php echo $js_class; ?>">
				<div class="hero__text-hld">
					<?php if (!empty($heading)) : ?>
						<div class="hero__heading ">
							<?php echo $heading; ?>
						</div>
					<?php endif; ?>

					<?php if (!empty($subheading)) : ?>
						<div class="hero__subheading">
							<?php echo $subheading; ?>
						</div>
					<?php endif; ?>
					<?php
						get_acf_components([
							'buttons' => [
								'data'    => $buttons,
								'classes' => 'hero__btns',
							],
						]);
					?>
				</div>
				<div class="hero__media-hld">
					<?php if ($media_type === 'image') : ?>
						<?php
							if (!empty($image['id'])) {
								echo bis_get_attachment_picture(
									$image['id'],
									[
										560  => [ 390 * 2, 772 * 2, 1 ],
										1024 => [ 1024, 1474, 1 ],
										1365 => [ 1400, 760, 1 ],
										2800 => [ 1400 * 2, 760 * 2, 1 ],
									],
									[
										'alt'   => $image['alt'] ? $image['alt'] : wp_strip_all_tags($heading ?? ''),
										'class' => 'hero__image', // Added specific class for styling
									]
								);
							} elseif (!empty($image['url'])) {
								echo '<img class="hero__image" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" />';
							}
						?>
					<?php elseif ($media_type === 'video' && !empty($video_group)) : ?>
						<?php
							get_acf_components([
								'video' => [
									'data'    => $video_group,
									'classes' => 'hero__video', // Added specific class for styling
								]
							]);
						?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
