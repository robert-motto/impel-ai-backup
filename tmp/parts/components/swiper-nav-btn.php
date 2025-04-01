<?php
	$classes = $args['classes'] ?? '';
	$type = $args['type'] ?? 'prev';


	if($type === 'prev') {
		$label = 'Previous';
		$classes .= ' u-swiper-nav u-swiper-nav--prev';
	} else {
		$label = 'Next';
		$classes .= ' u-swiper-nav u-swiper-nav--next';
	}
?>
<button type="button" class="<?php echo $classes; ?>">
	<?php
		get_icon('arrow-right');
	?>
	<span class="u-sr-only"><?php echo $label; ?></span>
</button>
