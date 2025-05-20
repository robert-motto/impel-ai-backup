<?php get_header(); ?>
<?php
	$post_id   = get_custom_queried_object_id();
	$post      = get_post($post_id);
	$post_type = get_post_type($post_id);
	$blocks    = parse_blocks($post->post_content);

	get_section('hero-post');
	get_section('table-of-contents');
	$reusable_block_name = get_field('reusable_block_name', $post_id);
	if (empty($reusable_block_name)) {
		if ($post_type === 'custom') {
			$reusable_block_name = 'Custom post additional sections';
		}else{
			$reusable_block_name = 'Blog post additional sections';
		}
	}
	echo get_reusable_block($reusable_block_name);
?>
<?php get_footer(); ?>
