<?php
	$data = $args['data'] ?? [];

	$has_buttons = $data['has_buttons'] === 'y' ? true : false;
	$buttons     = $data['buttons'] ?? [];
	$classes     = $args['classes'] ?? '';

	if (!empty($buttons) && $has_buttons) :
?>
	<div class="btns-hld <?php echo $classes; ?>">
		<?php foreach($buttons as $button) {
			get_acf_component('button', [
				'data' => $button['button_group'],
			]);
		} ?>
	</div>
<?php endif; ?>
