<?php /*
	Block Name: Hero
	Block Align: center
	Block Icon: superhero-alt
*/ ?>
<?php if (isset($block['data']['is_preview'])) : ?>
	<?php block_preview(__FILE__); ?>
<?php else : ?>
	<?php
	$group       				= blockFieldGroup(__FILE__);
	$color_mode      		= $group['section_settings_group']['mode'] ?? 'light';
	$color_mode_variant	= $group['mode_variant'] ?? 'regular';
	$heading         		= $group['heading_box_group'] ?? '';
	$buttons 						= $group['action_group_group'] ?? [];
	$media_type  				= $group['media_type'] ?? 'image';
	$media_position  		= $group['media_position'] ?? 'image';
	$text_position  		= $group['text_position'] ?? 'image';
	$image       				= $group['image'] ?? null;
	$image_mobile 			= $group['image_mobile'] ?? null;
	$video_group 				= $group['video_group'] ?? [];
	$show_logos_slider 	= $group['show_logos_slider'] ?? false;
	$slider_bg 					= $group['slider_bg'] ?? 'white';
	$logos_slider 			= $group['logos_slider'] ?? [];

	// Section classes
	$classes = ['js-section', 'l-section', 'l-section--hero', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}", "media-position-{$media_position}", "text-position-{$text_position}"];
	?>
	<section class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-block="hero">
		<div class="l-wrapper">
			<div class="hero">
				<div class="hero__text-hld">
					<?php
					get_acf_component(
						'heading-box',
						[
							'data' => $heading,
						],
					);
					?>
					<?php
					get_acf_component(
						'action-group',
						[
							'data' => $buttons,
							'classes' => 'hero__btns',
						],
					);
					?>
				</div>
				<div class="hero__media-hld">
					<?php if ($media_type === 'image') : ?>
						<?php $has_mobile = ($media_position === 'background' && (!empty($image_mobile['id']) || !empty($image_mobile['url']))); ?>
						<picture>
							<?php if ($has_mobile) : ?>
								<source media="(max-width: 767px)" srcset="<?php echo esc_url(!empty($image_mobile['url']) ? $image_mobile['url'] : (isset($image_mobile['id']) ? wp_get_attachment_url($image_mobile['id']) : '')); ?>">
							<?php endif; ?>
							<?php
							$desktop_src = !empty($image['url']) ? $image['url'] : (isset($image['id']) ? wp_get_attachment_url($image['id']) : '');
							$desktop_alt = $image['alt'] ?? wp_strip_all_tags($heading ?? '');
							$desktop_class = 'hero__image hero__image--desktop' . ($has_mobile ? ' has-mobile-sibling' : '');
							?>
							<img src="<?php echo esc_url($desktop_src); ?>" alt="<?php echo esc_attr($desktop_alt); ?>" class="<?php echo esc_attr($desktop_class); ?>">
						</picture>
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
			<?php
			if ($show_logos_slider && !empty($logos_slider)) :
				$logo_slides = [];
				foreach ($logos_slider as $logo) {
					if (!empty($logo['logo'])) {
						$logo_img = $logo['logo'];
						$alt_text = !empty($logo_img['alt']) ? $logo_img['alt'] : 'Logo';
						ob_start();
			?>

						<?php if (!empty($logo_img['id'])) : ?>
							<?php echo bis_get_attachment_picture(
								$logo_img['id'],
								[
									1920 => [180, 100, 1],
									2800 => [360, 200, 1],
								],
								[
									'alt'     => esc_attr($alt_text),
									'class'   => 'hero__logos-slider__logo',
									'loading' => 'lazy',
								],
							); ?>
						<?php elseif (!empty($logo_img['url'])) : ?>
							<img class="hero__logos-slider__logo" src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($alt_text); ?>" loading="lazy" />
						<?php endif; ?>
				<?php
						$logo_slides[] = ob_get_clean();
					}
				}

				$slide_count = count($logo_slides);
				if ($slide_count > 0) {
					$multiplier = ceil(20 / $slide_count);
					$logo_slides = array_merge(...array_fill(0, $multiplier, $logo_slides));
				}
				?>
				<div class="hero__logos-slider-container hero__logos-slider-container--<?php echo esc_attr($slider_bg); ?>">
					<?php
					get_component('slider', [
						'slides' => $logo_slides,
						'slider_settings' => [
							'show_progressbar' => false,
							'autoplay_speed' => 3000,
							'loop' => true,
							'space_between' => 60,
						],
						'classes' => 'hero__logos-slider'
					]); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
