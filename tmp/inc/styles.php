<?php
	function add_css() {
		global $post;

		wp_enqueue_style('main-styles', get_template_directory_uri() . '/dist/css/style.css', array(), filemtime(get_template_directory() . '/dist/css/style.css'), false);

		if(!empty($post)){
			$template_slug = get_page_template_slug($post->ID);
			$post_type = get_post_type($post->ID);

			if ($post_type !== 'page' || ($post_type === 'page' && $template_slug === 'page-table-of-contents.php')) {
				wp_enqueue_style('single-post-styles', get_stylesheet_directory_uri() . '/dist/css/single-post.css', array(), filemtime(get_theme_file_path('/dist/css/single-post.css')), false);
			}
		}
	}
	add_action('wp_enqueue_scripts', 'add_css');
