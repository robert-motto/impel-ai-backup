<?php
	$data    = $args['data'] ?? [];
	$classes = $args['classes'] ?? '';

	$has_subheading  = $data['has_subheading'] === 'y' ? true : false;
	$subheading      = $data['subheading'] ?? '';
	$subheading_size = $data['subheading_size'] ?? '4';
?>
<?php if ($has_subheading && !empty($subheading)) : ?>
	<div class="<?php echo $classes; ?> t-subheading t-subheading--<?php echo $subheading_size; ?>">
		<?php echo $subheading; ?>
	</div>
<?php endif; ?>
