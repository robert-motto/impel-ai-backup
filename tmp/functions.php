<?php
	require_once('vendor/stoutlogic/acf-builder/autoload.php');
	require get_template_directory() . '/inc/core.php';
	require get_template_directory() . '/inc/scripts.php';
	require get_template_directory() . '/inc/styles.php';
	require get_template_directory() . '/inc/menus.php';
	require get_template_directory() . '/inc/custom-taxonomy.php';
	require get_template_directory() . '/inc/get-primary-category.php';
	require get_template_directory() . '/inc/hiding-editor.php';
	require get_template_directory() . '/inc/acf.php';
	require get_template_directory() . '/inc/ajax.php';
	require get_template_directory() . '/inc/excerpt.php';
	require get_template_directory() . '/inc/blog.php';
	require get_template_directory() . '/inc/gutenberg.php';
	require get_template_directory() . '/inc/seo.php';
	require get_template_directory() . '/inc/dequeue.php';
	require get_template_directory() . '/inc/get-reusable-block.php';
	require get_template_directory() . '/inc/admin-menu.php';

	//helpers
	require get_template_directory() . '/inc/helpers/get-template-part-shorthand.php';
	require get_template_directory() . '/inc/helpers/find-strpos-in-array.php';
	require get_template_directory() . '/inc/helpers/get-custom-queried-object-id.php';
	require get_template_directory() . '/inc/helpers/section-settings-attributes.php';
    require get_template_directory() . '/inc/helpers/embed-player-id.php';
	require get_template_directory() . '/inc/helpers/reading-time.php';

	//featured posts
	global $featured_loaded_posts;
	$featured_loaded_posts = [];
