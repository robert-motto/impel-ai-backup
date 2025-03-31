<?php
	$heading = $args['data'] ?? [];

	$has_caption  = $heading['has_caption'] === 'y' ? true : false;
	$caption      = $heading['caption'] ?? '';
	$caption_size = $heading['caption_size'] ?? '2';
	$title        = $heading['title'] ?? '';
	$title_size   = $heading['title_size'] ?? 'h2';
	$title_weight = $heading['title_weight'] ?? 'regular';
	$classes      = $args['classes'] ?? '';
?>
<?php if (!empty($title)) : ?>
	<heading class="heading t-heading t-heading--<?php echo $title_size; ?> t-weight--<?php echo $title_weight; ?> <?php echo $classes; ?>">
		<?php if (!empty($caption) && $has_caption) : ?>
			<span class="heading__caption caption t-caption t-caption--<?php echo $caption_size; ?>"><?php echo $caption; ?></span>
		<?php endif; ?>
		<?php echo $title;?>
	</heading>
<?php endif; ?>
