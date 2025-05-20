<?php
	$id            = $args['id'] ?? '';
	$classes       = $args['classes'] ?? '';
	$order_options = $args['order_options'] ?? [];
	$active_order  = $args['active_order'];
	$js_classes    = $args['js_classes'] ?? '';
?>

<div class="select <?php echo $classes; ?>">
	<input type="checkbox" id="<?php echo $id; ?>" hidden>
	<label for="<?php echo $id; ?>" class="select__label">
		<?php echo $order_options[$active_order]['label']; ?>
		<?php
			get_icon('chevron-down', [
				'classes' => 'select__label__icon',
			]);
		?>
	</label>
	<div class="select__dropdown">
		<?php foreach ($order_options as $key => $option): ?>
			<span class="select__option <?php echo ($key === $active_order ? 'is-hidden' : '').' '.$js_classes; ?> " data-value="<?php echo $key; ?>">
				<?php echo $option['label']; ?>
			</span>
		<?php endforeach; ?>
	</div>
</div>
