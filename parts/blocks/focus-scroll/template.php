<?php /*
	Block Name: Focus Scroll
	Block Align: center
	Block Icon: format-aside
*/ ?>
<?php if (isset($block['data']['is_preview'])) : ?>
	<?php block_preview(__FILE__); ?>
<?php else : ?>
	<?php
	$group           		= isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
	$layout_variant  		= $group['layout_variant'] ?? 'text-left';
	$color_mode      		= $group['section_settings_group']['mode'] ?? 'light';
	$color_mode_variant	= $group['mode_variant'] ?? 'regular';
	$heading         		= $group['heading_box_group'] ?? '';
	$items     					= $group['items'] ?? [];

	// Section classes
	$classes = ['l-section', 'l-section--focus-scroll', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}",];

	// Row classes for layout variants
	$row_classes = ['focus-scroll', 'l-wrapper'];
	if ($layout_variant === 'text-right') {
		$row_classes[] = 'focus-scroll--reverse';
	}

	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="focus-scroll" data-variant="<?php echo esc_attr($layout_variant); ?>">
		<?php
		get_acf_component(
			'heading-box',
			[
				'data' => $heading,
			],
		);
		?>
		<div class="focus-scroll-wrapper js-focus-scroll-wrapper" style="height: <?php echo count($items) * 100 ?>vh">
			<div class="focus-scroll-inner-wrapper">
				<div class="<?php echo esc_attr(implode(' ', $row_classes)); ?>">
					<div class="focus-scroll__content-wrapper">
						<div class="focus-scroll__content-hld">
							<?php if (!empty($items)) : ?>
								<div class="focus-scroll__items">
									<?php foreach ($items as $key => $item) : ?>
										<div class="focus-scroll__item <?php echo $key === 0 ? 'focus-scroll__item--active' : ''; ?>">
											<?php if (!empty($item['item_icon'])) : ?>
												<div class="focus-scroll__item-icon">
													<?php echo wp_get_attachment_image($item['item_icon']['id'], 'medium', false, ['loading' => 'lazy']); ?>
												</div>
											<?php endif; ?>
											<div class="focus-scroll__item-content">
												<?php if (!empty($item['item_title'])) : ?>
													<p class="focus-scroll__item-title"><?php echo esc_html($item['item_title']); ?></p>
												<?php endif; ?>
												<?php if (!empty($item['item_subtitle']) || !empty($item['item_text'])) : ?>
													<div class="focus-scroll__item-content-text">
														<?php if (!empty($item['item_subtitle'])) : ?>
															<p class="focus-scroll__item-subtitle"><?php echo esc_html($item['item_subtitle']); ?></p>
														<?php endif; ?>
														<?php if (!empty($item['item_text'])) : ?>
															<div class="focus-scroll__item-text"><?php echo wp_kses_post($item['item_text']); ?></div>
														<?php endif; ?>
													</div>
												<?php endif; ?>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="focus-scroll__media-hld">
							<?php foreach ($items as $item) :
								$media_type 	= $item['media_type'] ?? 'image';
								$image      	= $item['image'] ?? '';
								$video_group	= $item['video_group'] ?? [];

								// Set fallback image if none is selected and media type is image
								if ($media_type === 'image' && (empty($image) || !isset($image['id']))) {
									$fallback_image_path = get_template_directory() . '/screenshot.jpg';
									$fallback_image_uri = get_template_directory_uri() . '/screenshot.jpg';
									if (file_exists($fallback_image_path)) {
										$fallback_attachment = attachment_url_to_postid($fallback_image_uri);
										if ($fallback_attachment) {
											$image = ['id' => $fallback_attachment];
										} else {
											$image = [
												'url' => $fallback_image_uri,
												'alt' => wp_strip_all_tags($heading ?? 'Content block image')
											];
										}
									}
								}
							?>
								<?php if ($media_type === 'image') : ?>
									<?php
									if (!empty($image['id'])) {
										echo bis_get_attachment_picture(
											$image['id'],
											[
												560  => [560, 373, 1],
												1024 => [720, 480, 1],
												1920 => [720, 480, 1],
												2800 => [720 * 2, 480 * 2, 1],
											],
											[
												'alt'     => $image['alt'] ? $image['alt'] : wp_strip_all_tags($heading ?? ''),
												'class'   => 'focus-scroll__img',
												'loading' => 'lazy',
											],
										);
									} elseif (!empty($image['url'])) {
										echo '<img class="focus-scroll__img" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" loading="lazy" />';
									}
									?>
								<?php elseif ($media_type === 'video' && !empty($video_group)) : ?>
									<?php
									get_acf_components([
										'video' => [
											'data'    => $video_group,
											'classes' => 'focus-scroll__video',
										]
									]);
									?>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>