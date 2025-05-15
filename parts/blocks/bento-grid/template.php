<?php /*
	Block Name: Bento Grid
	Block Align: center
	Block Icon: grid-view
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group          		= blockFieldGroup(__FILE__);
		$color_mode      		= $group['section_settings_group']['mode'] ?? 'light';
		$color_mode_variant	= $group['mode_variant'] ?? 'regular';
		$heading        		= $group['heading_box_group'] ?? '';
		$segments        		= $group['segments'] ?? [];

		// Section classes
		$classes = ['l-section', 'l-section--bento-grid-section', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}"];
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-block="bento-grid-section">
		<div class="l-wrapper">
			<div class="bento-grid-section">
				<div class="bento-grid-section__header">
					<?php
						get_acf_component(
							'heading-box', [
								'data' => $heading,
							],
						);
					?>
				</div>
				<div class="bento-grid-section__segments">
					<?php if (!empty($segments)) : ?>
						<?php foreach ($segments as $segment) : ?>
							<div class="bento-grid-section__segment bento-grid-section__segment--<?php echo esc_attr($segment['segment_type']); ?>">
								<?php
								// First tile (always present)
								$tile_one = $segment['tile_one'] ?? [];
								if (!empty($tile_one)) :
								?>
									<div class="bento-grid-section__tile">
										<?php if (!empty($tile_one['tile_image'])) : ?>
											<div class="bento-grid-section__tile-image">
												<?php echo wp_get_attachment_image($tile_one['tile_image']['ID'], 'large'); ?>
											</div>
										<?php endif; ?>
										<div class="bento-grid-section__tile-content">
											<?php if (!empty($tile_one['tile_title'])) : ?>
												<h3 class="bento-grid-section__tile-title"><?php echo esc_html($tile_one['tile_title']); ?></h3>
											<?php endif; ?>
											<?php if (!empty($tile_one['tile_text'])) : ?>
												<div class="bento-grid-section__tile-text"><?php echo $tile_one['tile_text']; ?></div>
											<?php endif; ?>
											<?php if (!empty($tile_one['action_group_group'])) : ?>
												<?php
													get_acf_component(
														'action-group', [
															'data' => $tile_one['action_group_group'],
															'classes' => 'bento-grid-section__tile-btns',
														],
													);
												?>
											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?>

								<?php
								// Second tile (only if segment_type is 'double')
								if ($segment['segment_type'] === 'double') :
									$tile_two = $segment['tile_two'] ?? [];
									if (!empty($tile_two)) :
									?>
										<div class="bento-grid-section__tile">
											<?php if (!empty($tile_two['tile_image'])) : ?>
												<div class="bento-grid-section__tile-image">
													<?php echo wp_get_attachment_image($tile_two['tile_image']['ID'], 'large'); ?>
												</div>
											<?php endif; ?>
											<div class="bento-grid-section__tile-content">
												<?php if (!empty($tile_two['tile_title'])) : ?>
													<h3 class="bento-grid-section__tile-title"><?php echo esc_html($tile_two['tile_title']); ?></h3>
												<?php endif; ?>
												<?php if (!empty($tile_two['tile_text'])) : ?>
													<div class="bento-grid-section__tile-text"><?php echo $tile_two['tile_text']; ?></div>
												<?php endif; ?>
												<?php if (!empty($tile_two['action_group_group'])) : ?>
													<?php
														get_acf_component(
															'action-group', [
																'data' => $tile_two['action_group_group'],
																'classes' => 'bento-grid-section__tile-btns',
															],
														);
													?>
												<?php endif; ?>
											</div>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
