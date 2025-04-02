<?php /*
	Block Name: General Metrics Section
	Block Align: center
	Block Icon: chart-bar
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group          = blockFieldGroup(__FILE__);
		$caption        = $group['caption'] ?? '';
		$heading        = $group['heading'] ?? '';
		$content        = $group['content'] ?? '';
		$buttons        = $group['buttons_group'] ?? [];
		$metrics        = $group['metrics'] ?? [];

		// Section classes
		$classes = ['l-section', 'l-section--general-metrics-section', 'js-general-metrics-section'];
		if (!empty($group['section_settings_group']['background_color'])) {
			$classes[] = 'is-' . $group['section_settings_group']['background_color'];
		} else {
			$classes[] = 'is-light';
		}
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="general-metrics-section">
		<div class="l-wrapper">
			<div class="general-metrics-section">
				<div class="general-metrics-section__header">
					<?php if (!empty($caption)) : ?>
						<div class="general-metrics-section__caption">
							<?php echo esc_html($caption); ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($heading)) : ?>
						<div class="general-metrics-section__heading">
							<?php echo $heading; ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($content)) : ?>
						<div class="general-metrics-section__content">
							<?php echo $content; ?>
						</div>
					<?php endif; ?>
					<?php
						if (!empty($buttons)) {
							get_acf_components([
								'buttons' => [
									'data'    => $buttons,
									'classes' => 'general-metrics-section__buttons',
								],
							]);
						}
					?>
				</div>
				<?php if (!empty($metrics)) : ?>
					<div class="general-metrics-section__metrics">
						<?php foreach ($metrics as $metric) : ?>
							<div class="general-metrics-section__metric">
								<div class="general-metrics-section__metric-value">
									<?php echo esc_html($metric['metric_value'] ?? ''); ?>
								</div>
								<div class="general-metrics-section__metric-label">
									<?php echo esc_html($metric['metric_label'] ?? ''); ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
