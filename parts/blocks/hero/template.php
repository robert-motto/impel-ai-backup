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

	// Section classes
	$classes = ['l-section', 'l-section--hero', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}", "media-position-{$media_position}", "text-position-{$text_position}"];
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
		</div>
	</section>
<?php endif; ?>