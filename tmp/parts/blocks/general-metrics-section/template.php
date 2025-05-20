<?php /*
	Block Name: General Metrics Section
	Block Align: center
	Block Icon: chart-bar
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group          		= blockFieldGroup(__FILE__);
		$color_mode      		= $group['section_settings_group']['mode'] ?? 'light';
		$color_mode_variant	= $group['mode_variant'] ?? 'regular';
		$heading        		= $group['heading_box_group'] ?? '';
		$metrics        		= $group['metrics'] ?? [];

		// Section classes
		$classes = ['l-section', 'l-section--general-metrics-section', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}"];
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-block="general-metrics-section">
		<div class="l-wrapper">
			<div class="general-metrics-section">
				<div class="general-metrics-section__header">
					<?php
						get_acf_component(
							'heading-box', [
								'data' => $heading,
							],
						);
					?>
				</div>
				<div class="general-metrics-section__metrics">
						<?php if (!empty($metrics)) : ?>
							<?php foreach ($metrics as $metric) : ?>
								<div class="general-metrics-section__metric general-metrics-section__metric--<?php echo esc_html($metric['variant'] ?? 'wide'); ?>">
									<div class="general-metrics-section__metric-value">
										<?php echo esc_html($metric['metric_value'] ?? ''); ?>
									</div>
									<div class="general-metrics-section__metric-label">
										<?php echo esc_html($metric['metric_label'] ?? ''); ?>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
			</div>
		</div>
	</section>
<?php endif; ?>
