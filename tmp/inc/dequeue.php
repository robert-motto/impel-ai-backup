<?php
	// Remove CSS from loading on the frontend
	function smartwp_remove_wp_block_library_css() {
		wp_dequeue_style('gform_theme');
		wp_dequeue_style('gform_basic');
		wp_dequeue_style('wp-block-library');
		wp_dequeue_style('search-filter-plugin-styles');
		// WPML styles
		// wp_dequeue_style('wpml-legacy-horizontal-list-0');
		// WooCommerce styles
		// wp_dequeue_style('wc-blocks-style');
		// wp_dequeue_style('wc-blocks-vendors-style');
		// wp_dequeue_style('woocommerce-general');
		// wp_dequeue_style('woocommerce-layout');
		// wp_dequeue_style('woocommerce-smallscreen');
		// wp_dequeue_style('wcml-dropdown-0');
		// wp_dequeue_style('photoswipe');
		// wp_dequeue_style('photoswipe-default-skin');
	}
	add_action('wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100);

	// Remove JS scripts from loading on the frontend
	// function project_dequeue_unnecessary_scripts() {
	//     wp_dequeue_script('babel-polyfill');
	//     wp_deregister_script('babel-polyfill');
	// }
	// add_action('wp_print_scripts', 'project_dequeue_unnecessary_scripts');
