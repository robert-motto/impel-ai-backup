<?php /*
	Block Name: Tertiary CTA
	Block Align: center
	Block Icon: megaphone
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group			= isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$color_mode	= $group['section_settings_group']['mode'] ?? 'light';
		$caption		= $group['caption'] ?? '';
		$heading		= $group['heading'] ?? '';
		$content		= $group['content'] ?? '';
		$buttons		= $group['action_group_group'] ?? [];

		// Section classes
		$classes = ['l-section', 'l-section--tertiary-cta', 'color-mode-' . ($color_mode === 'is-dark' ? 'is-light' : 'is-dark')];
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="tertiary-cta">
		<div class="l-wrapper">
			<div class="tertiary-cta__box" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/parts/blocks/tertiary-cta/cta_tertiary_' . ( $color_mode === 'is-dark' ? 'light' : 'dark' ) . '_glimmer.jpg' ); ?>');">
				<div class="tertiary-cta__content">
					<?php if (!empty($caption)) : ?>
						<p class="tertiary-cta__caption">
							<?php echo esc_html($caption); ?>
						</p>
					<?php endif; ?>

					<?php if (!empty($heading)) : ?>
						<div class="tertiary-cta__heading">
							<?php echo $heading; ?>
						</div>
					<?php endif; ?>

					<?php if (!empty($content)) : ?>
						<p class="tertiary-cta__body">
							<?php echo $content; ?>
						</p>
					<?php endif; ?>
				</div>

					<div class="tertiary-cta__buttons">
						<?php
							get_acf_component(
								'action-group', [
									'data' => $buttons,
									// 'classes' => 'main-cta__btns',
								],
							);
						?>
					</div>
			</div>
		</div>
	</section>
<?php endif; ?>
