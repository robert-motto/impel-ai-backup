<?php /*
	Block Name: Content Block Left/Right With Metrics
	Block Align: center
	Block Icon: format-aside
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group           = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$layout_variant  = $group['layout_variant'] ?? 'text-left';
		$caption         = $group['caption'] ?? '';
		$heading         = $group['heading'] ?? '';
		$content         = $group['content'] ?? '';
		$metrics         = $group['metrics'] ?? [];

		// Section classes
		$classes = ['l-section', 'l-section--content-block-metrics', 'js-content-block-metrics'];

		// Row classes for layout variants
		$row_classes = ['content-block-metrics', 'l-wrapper'];
		if ($layout_variant === 'text-right') {
			$row_classes[] = 'content-block-metrics--reverse';
		}
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="content-block-metrics" data-variant="<?php echo esc_attr($layout_variant); ?>">
		<div class="<?php echo esc_attr(implode(' ', $row_classes)); ?>">
			<div class="content-block-metrics__content-hld">
				<?php if (!empty($caption)) : ?>
					<div class="content-block-metrics__caption">
						<?php echo esc_html($caption); ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($heading)) : ?>
					<div class="content-block-metrics__heading">
						<?php echo $heading; ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($content)) : ?>
					<div class="content-block-metrics__body">
						<?php echo $content; ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="content-block-metrics__metrics-hld">
				<?php foreach ($metrics as $metric) : ?>
					<div class="content-block-metrics__metric">
						<div class="content-block-metrics__metric-value">
							<?php echo esc_html($metric['metric_value']); ?>
						</div>
						<div class="content-block-metrics__metric-label">
							<?php echo esc_html($metric['metric_label']); ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
