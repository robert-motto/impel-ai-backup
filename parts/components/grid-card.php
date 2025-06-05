<?php
$item = $args['item'] ?? [];
$item_style = $args['item_style'] ?? 'with-icons';
$display_mode = $args['display_mode'] ?? 'grid';

$item_heading = $item['item_heading'] ?? '';
$item_content = $item['item_content'] ?? '';
$item_link = $item['item_link'] ?? '';
$image = $item['image'] ?? '';
$svg_icon = $item['svg_icon'] ?? '';
$item_show_icon = $item['item_show_icon'] ?? true;
$item_has_metric_box = $item['item_has_metric_box'] ?? false;
$item_metric_value = $item['item_metric_value'] ?? '';
$item_metric_description = $item['item_metric_description'] ?? '';
$item_metric_icon = $item['item_metric_icon'] ?? 'arrow-up-right';

// Different image sizes for grid vs carousel
$image_sizes = $display_mode === 'carousel' ? [
	560  => [560, 373, 1],
	1024 => [408, 272, 1],
	1920 => [408, 272, 1],
	2800 => [408 * 2, 272 * 2, 1],
] : [
	560  => [560, 373, 1],
	1024 => [720, 480, 1],
	1920 => [720, 480, 1],
	2800 => [720 * 2, 480 * 2, 1],
];
?>

<?php if (!empty($item_link) && $display_mode === 'grid') : ?>
	<a href="<?php echo esc_url($item_link['url']); ?>"
		class="grid-card grid-card--link"
		<?php echo !empty($item_link['target']) ? 'target="' . esc_attr($item_link['target']) . '"' : ''; ?>
		aria-label="<?php echo esc_attr($item_link['title'] ?? $item_heading ?? 'Grid item link'); ?>">
<?php else : ?>
	<div class="grid-card <?php echo !empty($item_link) ? 'grid-card--link' : ''; ?>">
<?php endif; ?>

<?php if (!empty($item_link) && $display_mode === 'carousel') : ?>
	<a href="<?php echo esc_url($item_link['url']); ?>"
		class="grid-card__link-wrapper"
		<?php echo !empty($item_link['target']) ? 'target="' . esc_attr($item_link['target']) . '"' : ''; ?>
		aria-label="<?php echo esc_attr($item_link['title'] ?? $item_heading ?? 'Grid item link'); ?>">
<?php endif; ?>

	<div class="grid-of-items__media-container<?php echo ($item_style === 'with-icons' && !$item_show_icon) ? ' grid-of-items__media-container--no-icon' : ''; ?>">
		<?php if ($item_style === 'with-images' && !empty($image)) : ?>
			<?php
			if (!empty($image['id'])) {
				echo bis_get_attachment_picture(
					$image['id'],
					$image_sizes,
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
		<?php elseif ($item_style === 'with-icons' && $item_show_icon && !empty($svg_icon)) : ?>
			<?php
			if (!empty($svg_icon['id'])) {
				$svg_class = 'grid-of-items__svg';
				$svg_url_for_class = wp_get_attachment_url($svg_icon['id']);
				if ($svg_url_for_class) {
					$filename_for_class = pathinfo($svg_url_for_class, PATHINFO_FILENAME);
					$sanitized_filename = sanitize_title($filename_for_class);
					$svg_class .= ' is-' . strtolower($sanitized_filename);
				}
				echo wp_get_attachment_image(
					$svg_icon['id'],
					'full',
					false,
					[
						'class' => esc_attr($svg_class),
						'loading' => 'lazy',
					]
				);
			} elseif (!empty($svg_icon['url'])) {
				$svg_class = 'grid-of-items__svg';
				$filename_for_class = pathinfo($svg_icon['url'], PATHINFO_FILENAME);
				$sanitized_filename = sanitize_title($filename_for_class);
				$svg_class .= ' is-' . strtolower($sanitized_filename);
				echo '<img class="' . esc_attr($svg_class) . '" src="' . esc_url($svg_icon['url']) . '" alt="' . esc_attr($svg_icon['alt'] ?? 'SVG icon') . '"  />';
			}
			?>
		<?php endif; ?>
	</div>

	<div class="grid-of-items__content">
		<?php if (!empty($item_heading)) : ?>
			<div class="grid-card__heading">
				<?php echo $item_heading; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($item_content)) : ?>
			<div class="grid-card__content">
				<?php echo $item_content; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($item_link)) : ?>
			<div class="grid-card__link">
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
				<div class="grid-card__metric-box">
					<div class="grid-card__metric-value">
						<span><?php echo esc_html($item_metric_value); ?></span>
						<?php if ($item_metric_icon !== 'none' && function_exists('get_icon')) : ?>
							<div class="grid-card__metric-icon">
								<?php get_icon($item_metric_icon); ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="grid-card__metric-description">
						<?php echo esc_html($item_metric_description); ?>
					</div>
				</div>
			<?php endif;
		}
		?>
	</div> <?php // .grid-of-items__content ?>

	<?php if (!empty($item_link) && $display_mode === 'carousel') : ?>
		</a>
	<?php endif; ?>

<?php if (!empty($item_link) && $display_mode === 'grid') : ?>
	</a>
<?php else : ?>
	</div> <?php // .grid-card ?>
<?php endif; ?>
