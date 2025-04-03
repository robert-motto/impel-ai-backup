<?php /*
	Block Name: Main CTA
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
		$has_background = $group['has_background'] ?? false;
		$background_color = $group['background_color'] ?? 'dark';

		$classes = ['l-section', 'l-section--main-cta', 'js-main-cta'];
		if ($has_background) {
			$classes[] = 'is-' . $background_color;
		}
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="main-cta">
		<div class="main-cta l-wrapper">
			<div class="main-cta__content">
				<?php if (!empty($caption)) : ?>
					<div class="main-cta__caption">
						<?php echo esc_html($caption); ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($heading)) : ?>
					<div class="main-cta__heading">
						<?php echo $heading; ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($content)) : ?>
					<div class="main-cta__body">
						<?php echo $content; ?>
					</div>
				<?php endif; ?>
				<?php
					get_acf_components([
						'buttons' => [
							'data'    => $buttons,
							'classes' => 'main-cta__btns',
						],
					]);
				?>
			</div>
		</div>
	</section>
<?php endif; ?>
