<?php /*
	Block Name: Shortlist
	Block Align: center
	Block Icon: list-view
*/ ?>
<?php if (isset($block['data']['is_preview'])) : ?>
	<?php block_preview(__FILE__); ?>
<?php else : ?>
	<?php
		$group           	= isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$color_mode      	= $group['section_settings_group']['mode'] ?? 'light';
		$heading         	= $group['heading'] ?? '';
		$buttons_group   	= $group['buttons_group'] ?? [];
		$type_of_display	= $group['type_of_display'] ?? 'newest';
		$selected_posts 	= $group['selected_posts'] ?? [];
		$show_images     	= $group['show_images'] ?? true;
		$button_settings 	= $group['button_settings_group'] ?? [];
		$items = [];
		if ($type_of_display === 'custom' && !empty($selected_posts)) {
			foreach ($selected_posts as $post_id) {
				$thumbnail_id = get_post_thumbnail_id($post_id);
				$thumbnail = $thumbnail_id ? [
					'id' => $thumbnail_id,
					'alt' => get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) ?: get_the_title($post_id),
				] : '';
				$categories = get_the_category($post_id);
				$category = !empty($categories) ? $categories[0]->name : '';
				$title = get_the_title($post_id);
				$reading_time = reading_time($post_id);
				$link = [
					'url' => get_the_permalink($post_id),
					'target' => '_self',
				];
				$items[] = [
					'thumbnail' => $thumbnail,
					'category' => $category,
					'title' => $title,
					'reading_time' => $reading_time,
					'link' => $link,
				];
			}
		} else {
			// Fallback to 3 newest posts
			$query_args = [
				'post_status'    => 'publish',
				'post_type'      => 'post',
				'posts_per_page' => 3,
				'orderby'        => 'date',
				'order'          => 'DESC',
			];
			$the_query = new WP_Query($query_args);
			if ($the_query->have_posts()) {
				while ($the_query->have_posts()) {
					$the_query->the_post();
					$post_id = get_the_ID();
					$thumbnail_id = get_post_thumbnail_id($post_id);
					$thumbnail = $thumbnail_id ? [
						'id' => $thumbnail_id,
						'alt' => get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) ?: get_the_title($post_id),
					] : '';
					$categories = get_the_category($post_id);
					$category = !empty($categories) ? $categories[0]->name : '';
					$title = get_the_title($post_id);
					$reading_time = reading_time($post_id);
					$link = [
						'url' => get_the_permalink($post_id),
						'target' => '_self',
					];
					$items[] = [
						'thumbnail' => $thumbnail,
						'category' => $category,
						'title' => $title,
						'reading_time' => $reading_time,
						'link' => $link,
					];
				}
				wp_reset_postdata();
			}
		}

		// Section classes
		$classes = ['js-section', 'l-section', 'l-section--shortlist', 'js-shortlist', "color-mode-{$color_mode}"];
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="shortlist">
		<div class="l-wrapper">
			<div class="shortlist">
				<div class="shortlist__header">
					<?php if (!empty($heading)) : ?>
						<h2 class="shortlist__heading">
							<?php echo $heading; ?>
						</h2>
						<?php
							get_acf_components([
								'buttons' => [
									'data' => $buttons_group,
									'classes' => 'shortlist__buttons',
								],
							]);
						?>
					<?php endif; ?>
				</div>
				<?php if (!empty($items)) : ?>
					<?php
						$slides = [];
						foreach ($items as $item) {
							ob_start();
							get_component('card', [
								'item' => $item,
								'show_image' => $show_images,
								'button_settings' => $button_settings
							]);
							$slides[] = ob_get_clean();
						}
						$classes = 'shortlist__slider' . (count($slides) <= 3 ? ' shortlist__slider--hide-desktop-nav' : '');
						get_component('slider', [
							'slides' => $slides,
							'slider_settings' => [
								'slides_per_view' => 3,
								'show_navigation' => true,
								'show_progressbar' => true,
							],
							'classes' => $classes
						]);
					?>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
