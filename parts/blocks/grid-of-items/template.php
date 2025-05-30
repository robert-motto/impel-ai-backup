<?php /*
	Block Name: Grid of Items
	Block Align: center
	Block Icon: grid-view

	TODO:
	- Add metrics
	- Add offices variant
*/ ?>
<?php if (isset($block['data']['is_preview'])) : ?>
	<?php block_preview(__FILE__); ?>
<?php else : ?>
	<?php
		$group                                  = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$color_mode                             = $group['section_settings_group']['mode'] ?? 'light';
		$color_mode_variant                 = $group['mode_variant'] ?? 'regular';
		$heading                                = $group['heading_box_group'] ?? '';

		$item_style                             = $group['item_style'] ?? 'with-icons';
		$grid_items                             = $group['grid_items'] ?? [];
		$columns_count                          = $group['columns_count'] ?? '3';
		$display_mode                           = $group['display_mode'] ?? 'grid';

		// Carousel settings
		$carousel_slides_per_view_desktop = $group['carousel_slides_per_view_desktop'] ?? 3;
		$carousel_autoplay                      = $group['carousel_autoplay'] ?? false;
		$carousel_autoplay_speed                = $group['carousel_autoplay_speed'] ?? 3000;
		$carousel_pause_on_hover                = $group['carousel_pause_on_hover'] ?? true;
		$carousel_show_navigation               = $group['carousel_show_navigation'] ?? true;
		$carousel_show_progressbar              = $group['carousel_show_progressbar'] ?? true;
		$button_group                           = $group['button_group'] ?? [];

		// Section classes
		$classes = ['l-section', 'l-section--grid-of-items', 'js-grid-of-items', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}"];
		if ($display_mode === 'carousel') {
			$classes[] = 'l-section--grid-of-items--carousel';
		}


		// Grid item classes
		$grid_classes = ['grid-of-items__grid'];
		if ($item_style === 'with-icons') {
			$grid_classes[] = 'grid-of-items__grid--icons';
		} else {
			$grid_classes[] = 'grid-of-items__grid--images';
		}
		$grid_classes[] = 'grid-of-items__grid--cols-' . $columns_count;

	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-block="grid-of-items">

		<div class="grid-of-items l-wrapper l-wrapper--medium">
			<?php
			get_acf_component(
				'heading-box',
				[
					'data' => $heading,
				],
			);
			?>

			<?php if ($display_mode === 'grid') : ?>
				<div class="<?php echo esc_attr(implode(' ', $grid_classes)); ?>">
					<?php foreach ($grid_items as $item) : ?>
						<?php
						$item_heading = $item['item_heading'] ?? '';
						$item_content = $item['item_content'] ?? '';
						$item_link = $item['item_link'] ?? '';
						$media_type = $item['media_type'] ?? 'image'; // Assuming media_type exists per item from original
						$image = $item['image'] ?? '';
						$svg_icon = $item['svg_icon'] ?? '';

						?>

						<?php if (!empty($item_link)) : ?>
							<a href="<?php echo esc_url($item_link['url']); ?>"
								class="grid-of-items__item grid-of-items__item--link"
								<?php echo !empty($item_link['target']) ? 'target="' . esc_attr($item_link['target']) . '"' : ''; ?>
								aria-label="<?php echo esc_attr($item_link['title'] ?? $item_heading ?? 'Grid item link'); ?>">
						<?php else : ?>
							<div class="grid-of-items__item">
						<?php endif; ?>
						<div class="grid-of-items__media-container">
							<?php if ($item_style === 'with-images' && !empty($image)) : ?>
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
											'alt'     => $image['alt'] ? $image['alt'] : wp_strip_all_tags($item_heading ?? 'Grid item'),
											'class'   => 'grid-of-items__img',
											'loading' => 'lazy',
										],
									);
								} elseif (!empty($image['url'])) {
									echo '<img class="grid-of-items__img" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt'] ?? 'Grid item') . '"  />';
								}
								?>
							<?php elseif ($item_style === 'with-icons' && !empty($svg_icon)) : ?>
								<?php
								if (!empty($svg_icon['id'])) {
									echo wp_get_attachment_image(
										$svg_icon['id'],
										'full',
										false,
										[
											'class' => 'grid-of-items__svg',
											'loading' => 'lazy',
										]
									);
								} elseif (!empty($svg_icon['url'])) {
									echo '<img class="grid-of-items__svg" src="' . esc_url($svg_icon['url']) . '" alt="' . esc_attr($svg_icon['alt'] ?? 'SVG icon') . '"  />';
								}
								?>
							<?php endif; ?>
						</div>
						<div class="grid-of-items__content">

							<?php if (!empty($item_heading)) : ?>
								<div class="grid-of-items__item-heading">
									<?php echo $item_heading; ?>
								</div>
							<?php endif; ?>

							<?php if (!empty($item_content)) : ?>
								<div class="grid-of-items__item-content">
									<?php echo $item_content; ?>
								</div>
							<?php endif; ?>

							<?php if (!empty($item_link)) : ?>
								<div class="grid-of-items__item-link">
									<?php get_acf_component('button', [
										'data' => [
											'type' => 'link',
											'size' => 'regular',
											'has_icon' => 'y',
											'icon_position' => 'right',
											'button' => [
												'url' => $item_link['url'],
												'title' => $item_link['title'],
												'target' => $item_link['target'],
											],
										],
										'tag' => 'div',
									]); ?>
								</div>
							<?php endif; ?>
						</div>
						<?php if (!empty($item_link)) : ?>
							</a>
						<?php else : ?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
			</div>
			<?php elseif ($display_mode === 'carousel' && !empty($grid_items)) : ?>
				<?php
					$slides_content = [];
					foreach ($grid_items as $item) {
						ob_start();
						$item_heading = $item['item_heading'] ?? '';
						$item_content = $item['item_content'] ?? '';
						$item_link = $item['item_link'] ?? '';
						$image = $item['image'] ?? '';
						$svg_icon = $item['svg_icon'] ?? '';
						$item_has_metric_box = $item['item_has_metric_box'] ?? false;
						$item_metric_value = $item['item_metric_value'] ?? '';
						$item_metric_description = $item['item_metric_description'] ?? '';
						$item_metric_icon = $item['item_metric_icon'] ?? 'arrow-up-right';
						?>
						<div class="grid-of-items__item <?php echo !empty($item_link) ? 'grid-of-items__item--link' : ''; ?>">
							<?php if (!empty($item_link)) : ?>
								<a href="<?php echo esc_url($item_link['url']); ?>"
									class="grid-of-items__item-link-wrapper"
									<?php echo !empty($item_link['target']) ? 'target="' . esc_attr($item_link['target']) . '"' : ''; ?>
									aria-label="<?php echo esc_attr($item_link['title'] ?? $item_heading ?? 'Grid item link'); ?>">
							<?php endif; ?>
							<div class="grid-of-items__media-container">
								<?php if ($item_style === 'with-images' && !empty($image)) : ?>
									<?php
									if (!empty($image['id'])) {
										echo bis_get_attachment_picture(
											$image['id'],
											[
												560  => [560, 373, 1],
												1024 => [408, 272, 1],
												1920 => [408, 272, 1],
												2800 => [408 * 2, 272 * 2, 1],
											],
											[
												'alt'     => $image['alt'] ? $image['alt'] : wp_strip_all_tags($item_heading ?? 'Grid item'),
												'class'   => 'grid-of-items__img',
												'loading' => 'lazy',
											],
										);
									} elseif (!empty($image['url'])) {
										echo '<img class="grid-of-items__img" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt'] ?? 'Grid item') . '"  />';
									}
									?>
								<?php elseif ($item_style === 'with-icons' && !empty($svg_icon)) : ?>
									<?php
									if (!empty($svg_icon['id'])) {
										echo wp_get_attachment_image(
											$svg_icon['id'],
											'full',
											false,
											[
												'class' => 'grid-of-items__svg',
												'loading' => 'lazy',
											]
										);
									} elseif (!empty($svg_icon['url'])) {
										echo '<img class="grid-of-items__svg" src="' . esc_url($svg_icon['url']) . '" alt="' . esc_attr($svg_icon['alt'] ?? 'SVG icon') . '"  />';
									}
									?>
								<?php endif; ?>
							</div>
							<div class="grid-of-items__content">
								<?php if (!empty($item_heading)) : ?>
									<div class="grid-of-items__item-heading">
										<?php echo $item_heading; ?>
									</div>
								<?php endif; ?>

								<?php if (!empty($item_content)) : ?>
									<div class="grid-of-items__item-content">
										<?php echo $item_content; ?>
									</div>
								<?php endif; ?>

								<?php if (!empty($item_link)) : ?>
									<div class="grid-of-items__item-link">
										<?php get_acf_component('button', [
											'data' => [
												'type' => 'link',
												'size' => 'regular',
												'has_icon' => 'y',
												'icon_position' => 'right',
												'button' => [
													'url' => $item_link['url'],
													'title' => $item_link['title'],
													'target' => $item_link['target'],
												],
											],
											'tag' => 'div',
										]); ?>
									</div>
								<?php endif; ?>

								<?php
									if ($item_has_metric_box) {
										if (!empty($item_metric_value) && !empty($item_metric_description)) : ?>
											<div class="grid-of-items__metric-box">
												<div class="grid-of-items__metric-value">
													<span><?php echo esc_html($item_metric_value); ?></span>
													<?php if ($item_metric_icon !== 'none' && function_exists('get_icon')) : ?>
														<div class="grid-of-items__metric-icon">
															<?php get_icon($item_metric_icon); ?>
														</div>
													<?php endif; ?>
												</div>
												<div class="grid-of-items__metric-description">
													<?php echo esc_html($item_metric_description); ?>
												</div>
											</div>
										<?php endif;
									}
								?>
							</div> <?php // .grid-of-items__content ?>
							<?php if (!empty($item_link)) : ?>
								</a>
							<?php endif; ?>
						</div> <?php // .grid-of-items__item ?>
						<?php
						$slides_content[] = ob_get_clean();
					}

					$slider_component_settings = [
						'js_hook' => 'js-grid-of-items-swiper',
						'slides_per_view' => $carousel_slides_per_view_desktop,
						'autoplay_speed' => $carousel_autoplay ? $carousel_autoplay_speed : 0,
						'pause_on_hover' => $carousel_pause_on_hover,
						'show_navigation' => $carousel_show_navigation,
						'show_progressbar' => $carousel_show_progressbar,
					];

				?>
				<div class="grid-of-items__carousel">
					<?php
						get_component('slider', [
							'slides' => $slides_content,
							'button' => $button_group,
							'slider_settings' => $slider_component_settings
						]);
					?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
