<?php
	$data    = $args['data'] ?? [];
	$classes = $args['classes'] ?? '';

	$content      = $data['content'] ?? '';
	$content_size = $data['content_size'] ?? '2';
?>
<?php if (!empty($content)) : ?>
	<div class="<?php echo $classes; ?> t-body t-body--<?php echo $content_size; ?>">
		<?php echo $content; ?>
	</div>
<?php endif; ?>
