<?php get_header(); ?>
<?php
	$post_id = get_custom_queried_object_id();
	$post = get_post($post_id);
	$blocks = parse_blocks($post->post_content);
	if ($blocks) {
		foreach ($blocks as $block) {
			echo render_block($block);
		}
	}
?>

<?php get_footer(); ?>
