<?php
	function add_js() {
		global $post;

		wp_enqueue_script('main', get_stylesheet_directory_uri() . '/dist/js/main.min.js', array(), filemtime(get_theme_file_path('/dist/js/main.min.js')));
		wp_localize_script('main', 'settings', array(
			'ajaxurl' => admin_url('admin-ajax.php')
		));

		if(!empty($post)){
			$template_slug = get_page_template_slug($post->ID);
			$post_type = get_post_type($post->ID);

			if ($post_type !== 'page' || ($post_type === 'page' && $template_slug === 'page-table-of-contents.php')) {
				wp_enqueue_script('single-post', get_stylesheet_directory_uri() . '/dist/js/singlePost.min.js', array(), filemtime(get_theme_file_path('/dist/js/singlePost.min.js')));
			}
		}
	}
	add_action('wp_enqueue_scripts', 'add_js');
