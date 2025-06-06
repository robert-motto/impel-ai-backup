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
		} elseif ($item_style === 'with-images') {
			$grid_classes[] = 'grid-of-items__grid--images';
		} elseif ($item_style === 'portfolio') {
			$grid_classes[] = 'grid-of-items__grid--portfolio';
		}
		$grid_classes[] = 'grid-of-items__grid--cols-' . $columns_count;

	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-block="grid-of-items">

		<?php if ($display_mode === 'carousel') : ?>
			<div class="grid-of-items">
		<?php else : ?>
			<div class="grid-of-items l-wrapper l-wrapper--medium">
		<?php endif; ?>
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
						get_component('grid-card', [
							'item' => $item,
							'item_style' => $item_style,
							'display_mode' => $display_mode,
						]);
						?>
					<?php endforeach; ?>
				</div>
			<?php elseif ($display_mode === 'carousel' && !empty($grid_items)) : ?>
				<?php
					$slides_content = [];
					foreach ($grid_items as $item) {
						ob_start();
						get_component('grid-card', [
							'item' => $item,
							'item_style' => $item_style,
							'display_mode' => $display_mode,
						]);
						$slides_content[] = ob_get_clean();
					}

					$slider_component_settings = [
						'js_hook' => 'js-grid-of-items-swiper',
						'slides_per_view' => $carousel_slides_per_view_desktop,
						'autoplay_speed' => $carousel_autoplay ? $carousel_autoplay_speed : 0,
						'pause_on_hover' => $carousel_pause_on_hover,
						'show_navigation' => $carousel_show_navigation,
						'show_progressbar' => $carousel_show_progressbar,
						'space_between' => 24,
						'slides_offset_before' => 84,
					];

				?>
				<div class="grid-of-items__carousel">
					<?php
						$slider_button_data = $button_group;
						$slider_button_data['type'] = 'link';
						$slider_button_data['size'] = 'regular';
						$slider_button_data['has_icon'] = 'y';
						$slider_button_data['icon_position'] = 'right';
						get_component('slider', [
							'slides'          => $slides_content,
							'button'          => $slider_button_data,
							'slider_settings' => $slider_component_settings
						]);
					?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
