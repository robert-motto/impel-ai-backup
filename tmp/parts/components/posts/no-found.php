<?php
    $classes = $args['classes'] ?? '';
    $data = $args['data'] ?? [];
    $title = $data['title'] ?? '';
    $content = $data['content'] ?? '';
	$search_phrase = isset($_GET['search']) ? $_GET['search'] : '';
?>

<div class="no-found <?php echo $classes; ?>">
    <?php
		get_icon('no-results', [
			'classes' => 'no-found__icon',
		]);
	?>
	<?php if(!empty($title)) : ?>
		<h3 class="no-found__title"><?php echo $title; ?></h3>
    <?php endif; ?>
    <?php if(!empty($content)) : ?>
        <div class="no-found__content">
            <?php echo $content; ?>
        </div>
    <?php endif; ?>
</div>
