<?php /*
	Block Name: Content Block Left/Right With Metrics
	Block Align: center
	Block Icon: format-aside
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group           		= isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$layout_variant  		= $group['layout_variant'] ?? 'text-left';
		$color_mode      		= $group['section_settings_group']['mode'] ?? 'light';
		$color_mode_variant	= $group['mode_variant'] ?? 'regular';
		$heading         		= $group['heading_box_group'] ?? '';
		$metrics        		= $group['metrics'] ?? [];

		// TODO: add media asset support
		// $media_type      = $group['media_type'] ?? 'image';
		// $image           = $group['image'] ?? '';
		// $video_group     = $group['video_group'] ?? [];

		// Section classes
		$classes = ['l-section', 'l-section--content-block-metrics', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}"];

		// Row classes for layout variants
		$row_classes = ['content-block-metrics', 'l-wrapper'];
		if ($layout_variant === 'text-right') {
			$row_classes[] = 'content-block-metrics--reverse';
		}
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="content-block-metrics" data-variant="<?php echo esc_attr($layout_variant); ?>">
		<div class="<?php echo esc_attr(implode(' ', $row_classes)); ?>">
			<div class="content-block-metrics__content-hld">
				<?php
					get_acf_component(
						'heading-box', [
							'data' => $heading,
						],
					);
				?>
			</div>
			<div class="content-block-metrics__metrics-hld">
				<?php foreach ($metrics as $metric) : ?>
					<div class="content-block-metrics__metric">
						<?php if (!empty($metric['metric_icon']['id'])) : ?>
							<div class="content-block-metrics__metric-icon">
								<?php echo bis_get_attachment_picture(
									$metric['metric_icon']['id'],
									[
										560  => [ 180, 100, 1 ],
										1024 => [ 180, 100, 1 ],
										1920 => [ 180, 100, 1 ],
										2800 => [ 360, 200, 1 ],
									],
									[
										'alt'     => 'metric icon',
										'loading' => 'lazy',
									],
								); ?>
							</div>
						<?php endif; ?>
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
