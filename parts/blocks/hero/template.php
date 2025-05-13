<?php /*
	Block Name: Hero
	Block Align: center
	Block Icon: superhero-alt
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
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
		$video_group 				= $group['video_group'] ?? [];

		// Section classes
		$classes = ['l-section', 'l-section--hero', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}", "media-position-{$media_position}", "text-position-{$text_position}"];
	?>
	<section class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group);?>" data-block="hero">
		<div class="l-wrapper">
			<div class="hero">
				<div class="hero__text-hld">
					<?php
						get_acf_component(
							'heading-box', [
								'data' => $heading,
							],
						);
					?>
					<?php
						get_acf_component(
							'action-group', [
								'data' => $buttons,
								'classes' => 'hero__btns',
							],
						);
					?>
				</div>
				<div class="hero__media-hld">
					<?php if ($media_type === 'image') : ?>
						<?php
							if (!empty($image['id'])) {
								echo bis_get_attachment_picture(
									$image['id'],
									[
										560  => [ 390 * 2, 210 * 2, 1 ],
										1024 => [ 1024, 553, 1 ],
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
