<?php
	/* Template Name: Table of Contents */

	get_header();

	$post_id = get_custom_queried_object_id();
	$post = get_post($post_id);
	$blocks = parse_blocks($post->post_content);

	get_block('hero', [
		'data' => get_field('hero_group', $post_id),
	]);
	get_section('table-of-contents');
	$reusable_block_name = get_field('reusable_block_name', $post_id) ?? '';
	if (!empty($reusable_block_name)) {
		echo get_reusable_block($reusable_block_name);
	}
?>
<?php get_footer(); ?>
