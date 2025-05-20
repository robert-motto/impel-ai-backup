<?php
	function remove_from_menu() {
		remove_menu_page('edit-comments.php');
	}

	add_action('admin_menu', 'remove_from_menu');
	add_action('after_setup_theme', 'custom_remove_admin_bar');
	add_theme_support('align-wide');
	add_theme_support('align-full');

	//DISABLE XMLRPC
	add_filter('xmlrpc_enabled', '__return_false');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');

	function remove_xmlrpc_methods($methods) {
		return array();
	}

	add_filter('xmlrpc_methods', 'remove_xmlrpc_methods');

	function custom_remove_admin_bar() {
		if (is_user_logged_in()) {
			show_admin_bar(false);
		}
	}

	function _unregister_taxonomy() {
		global $wp_taxonomies;
		$taxonomy = 'category';
		if (taxonomy_exists($taxonomy)) {
			unset($wp_taxonomies[$taxonomy]);
		}
	}

	// add_action('init', '_unregister_taxonomy');

	add_filter('upload_mimes', 'cc_mime_types');
	function cc_mime_types($mimes) {
		$mimes['svg'] = 'image/svg+xml';

		return $mimes;
	}

	remove_action('wp_head', 'wp_generator');

	add_theme_support('post-thumbnails',
		array(
			'post',
			'page'
		));

	add_filter('wpseo_metabox_prio', function($prio) {
		return 'low';
	}, 10, 1);

	function mind_defer_scripts( $tag, $handle, $src ) {
       $defer = array(
			'main',
		);

		$block = __DIR__ . '/../parts/blocks/'.$handle;

		if (is_dir($block)) {
			$defer[] = $handle; // Add the handle to the defer array
		}
		if ( in_array( $handle, $defer ) ) {
            return str_replace( '></script>', ' async defer></script>', $tag );
        }
        return $tag;
    }

	add_filter('script_loader_tag', 'mind_defer_scripts', 10, 3);

	function defer_stylesheet($tag, $handle, $href) {
		$block = __DIR__ . '/../parts/blocks/'.$handle;
		if (is_dir($block)) {
			$tag = "<link rel='stylesheet' id='{$handle}-css' href='{$href}' type='text/css' media='print' onload=\"this.media='all'\" />";
		}
		return $tag;
	}

	add_filter('style_loader_tag', 'defer_stylesheet', 10, 3);

	function remove_head_scripts() {
		remove_action('wp_head', 'wp_print_scripts');
		remove_action('wp_head', 'wp_print_head_scripts', 9);
		remove_action('wp_head', 'wp_enqueue_scripts', 1);
		add_action('wp_footer', 'wp_print_scripts', 5);
		add_action('wp_footer', 'wp_enqueue_scripts', 1);
		add_action('wp_footer', 'wp_print_head_scripts', 5);
	}

	add_action('wp_enqueue_scripts', 'remove_head_scripts');

	function my_acf_admin_head() {
		add_action('acf/input/admin_head', 'my_acf_admin_head');
		?>

		<script type="text/javascript">
			(function ($) {
				$(document).ready(function () {
					if ($('.acf-field-5c8f523913ffa').length) {
						$('.acf-field-5c8f523913ffa .acf-input').append($('#postdivrich'));
						$('.acf-field-5c8f530a7d3c7 .acf-input').append($('#postexcerpt'));
					}
				});
			})(jQuery);
		</script>

		<style type="text/css">
			.acf-field #wp-content-editor-tools {
				background: transparent;
				padding-top: 0;
			}
		</style>

		<?php
	}

	/**
	 * Make Media attachments translatable with WPML
	 *
	 * Filter ACF images and galleries to switch attachment ids with their
	 * corresponding WPML translation.
	 */

	function my_acf_load_translated_attachment($value, $post_id, $field) {
		$newValue = $value;
		// Make sure we are using WPML
		if (function_exists('icl_object_id')) {
			// Galleries come in arrays
			if (is_array($value)) {
				$newValue = array();
				foreach ($value as $key => $id) {
					$newValue[$key] = icl_object_id($id, 'attachment');
				}
			} // Single images arrive as simple values
			else {
				$newValue = icl_object_id($value, 'attachment');
			}
		}

		return $newValue;
	}

	add_filter('acf/load_value/type=gallery', 'my_acf_load_translated_attachment', 10, 3);
	add_filter('acf/load_value/type=image', 'my_acf_load_translated_attachment', 10, 3);

	/**
	 * Manage admin menu.
	 *
	 * @return void
	 */
	function manage_admin_menu() {
		add_menu_page(
			'Reusable blocks', // Page title
			'Reusable blocks', // Menu title
			'edit_pages', // Capability required to access the menu item
			'/edit.php?post_type=wp_block', // URL slug
			'', // Callback function (optional)
			'dashicons-editor-table', // Icon (optional)
			4 // Position (optional)
		);
		remove_submenu_page('themes.php', 'site-editor.php?path=/patterns');
	}

	add_action('admin_menu', 'manage_admin_menu');

