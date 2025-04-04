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
		$has_background   = $group['has_background'] ?? true;
		$background_color = $group['background_color'] ?? 'light';
		$has_border_radius = $group['has_border_radius'] ?? true;
		$buttons_group = $group['buttons_group'] ?? [];

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
			</div>
		</div>
	</section>
<?php endif; ?>
