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
		$color_mode	= $group['section_settings_group']['mode'] ?? 'light';
		$caption 		= $group['caption'] ?? '';
		$heading 		= $group['heading'] ?? '';
		$content 		= $group['content'] ?? '';
		$buttons 		= $group['action_group_group'] ?? [];

		// Section classes
		$classes = ['js-section', 'l-section', 'l-section--main-cta', "color-mode-{$color_mode}"];

	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-block="main-cta" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/parts/blocks/main-cta/cta_main_' . ( $color_mode === 'is-dark' ? 'dark' : 'light' ) . '_glimmer.jpg' ); ?>');">
		<div class="main-cta l-wrapper">
			<div class="main-cta__content">
				<?php if (!empty($caption)) : ?>
					<p class="main-cta__caption">
						<?php echo esc_html($caption); ?>
					</p>
				<?php endif; ?>
				<?php if (!empty($heading)) : ?>
					<div class="main-cta__heading">
						<?php echo $heading; ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($content)) : ?>
					<p class="main-cta__body">
						<?php echo $content; ?>
					</p>
				<?php endif; ?>
				<?php
					get_acf_component(
						'action-group', [
							'data' => $buttons,
							'classes' => 'main-cta__btns',
						],
					);
				?>
			</div>
		</div>
	</section>
<?php endif; ?>
