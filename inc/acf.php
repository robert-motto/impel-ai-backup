<?php
	use StoutLogic\AcfBuilder\FieldsBuilder;
	define('FIELDS_DIR', dirname(__DIR__) . '/parts/fields/');
	define('BLOCK_FIELDS_DIR', dirname(__DIR__) . '/parts/blocks/');
	define('COMPONENTS_FIELDS_DIR', dirname(__DIR__) . '/parts/acf-components/');
	function custom_block_categories($categories) {
		return array_merge(array(
			array(
				'slug' => 'gutenberg-blocks',
				'title' => __('Custom Blocks'),
				'icon' => 'wordpress',
			),
		), $categories);
	}
	add_filter('block_categories_all', 'custom_block_categories', 10, 2);

	/* Register Custom Fields from Options, Template etc. */
	function acf_field_builder_registration() {
		if (is_dir(FIELDS_DIR)) {
			add_action('acf/init', function() {
				foreach (glob(FIELDS_DIR . '/*.php') as $file_path) {
					if (($fields = require_once $file_path) !== true) {
						if (!is_array($fields)) {
							$fields = [$fields];
						}
						foreach ($fields as $field) {
							if ($field instanceof FieldsBuilder) {
								acf_add_local_field_group($field->build());
							}
						}
					}
				}
			});
		}
	}

	/* Register Block Fields */
	function acf_block_field_builder_registration() {
		add_action('acf/init', function() {
			foreach (glob(BLOCK_FIELDS_DIR . '**/fields.php') as $file_path) {
				if (($fields = require_once $file_path) !== true) {
					if (!is_array($fields)) {
						$fields = [$fields];

					}
					foreach ($fields as $field) {
						if ($field instanceof FieldsBuilder) {
							acf_add_local_field_group($field->build());
						}
					}
				}
			}
		});
	}

	/* Register Component Fields */
	function acf_components_field_builder_registration() {
		add_action('acf/init', function() {
			foreach (glob(COMPONENTS_FIELDS_DIR . '**/fields.php') as $file_path) {
				if (($fields = require_once $file_path) !== true) {
					if (!is_array($fields)) {
						$fields = [$fields];

					}
					foreach ($fields as $field) {
						if ($field instanceof FieldsBuilder) {
							acf_add_local_field_group($field->build());
						}
					}
				}
			}
		});
	}

	/* Register Blocks */
	function acf_blocks_registration() {
		define('BLOCKS_DIR', dirname(__FILE__, 2) . '/parts/blocks');
		add_action('acf/init', function() {
			foreach (glob(BLOCKS_DIR . '/**/template.php') as $filepath) {
				$meta = get_file_data($filepath, array(
					'name' => 'Block Name',
					'description' => 'Block Description',
					'category' => 'Block Category',
					'post_types' => 'Post Types',
					'mode' => 'Block Mode',
					'toggle' => 'Block Toggle',
					'align' => 'Block Align',
					'icon' => 'Block Icon',
				));
				$post_types = array_filter(array_map('trim', explode(',', $meta['post_types'])));
				$template_path = basename(dirname($filepath));
				// Register the ACF block
				acf_register_block_type(array(
					'name' => $template_path,
					'title' => $meta['name'],
					'description' => $meta['description'],
					'category' => 'gutenberg-blocks',
					'post_types' => $post_types,
					'render_template' => get_template_directory() . '/parts/blocks/' . $template_path . '/template.php',
					'enqueue_assets' => function() use ($template_path) {
						block_assets($template_path);
					},
					'mode' => $meta['mode'] ? $meta['mode'] : 'edit',
					'align' => $meta['align'] ? $meta['align'] : 'full',
					'icon' => $meta['icon'],
					'supports' => array(
						'customClassName' => true,
						'anchor' => true,
						'jsx' => true,
						'mode' => $meta['toggle'] == 'false' ? false : true,
					),
					'example' => [
						'attributes' => [
							'mode' => 'preview',
							'data' => [
								'is_preview' => true,
							]
						],
					],
				));
			}
			// Register existing block assets
			function block_assets($template_path) {
				$block_styles = get_template_directory() . '/dist/css/' . $template_path . '/' . $template_path . '.css';
				$block_script = get_template_directory() . '/dist/js/' . $template_path . '.min.js';
				if (file_exists($block_styles)) {
					$cache_bust = '?' . filemtime($block_styles);
					wp_enqueue_style($template_path, get_template_directory_uri() . '/dist/css/' . $template_path . '/' . $template_path . '.css', array(), $cache_bust);
				}
				if (file_exists($block_script)) {
					$cache_bust = '?' . filemtime($block_script);
					wp_enqueue_script($template_path, get_template_directory_uri() . '/dist/js/' . $template_path . '.min.js', array(), $cache_bust, true);
				}
				additional_block_assets($template_path);
			}

			function additional_block_assets($template_path) {
				$block_assets = dirname(__FILE__, 2) . '/parts/blocks/'.$template_path.'/assets/';
				foreach (glob($block_assets. '*.css') as $filepath) {
					$searchString = '/assets/';
					// Find the position of '/assets/' in the input string
					$assetsPosition = strpos($filepath, $searchString);
					// Get the position right after '/assets/'
					$startPosition = $assetsPosition + strlen($searchString);
					// Get the substring after '/assets/'
					$file_name = substr($filepath, $startPosition, -4);

					$block_styles = get_template_directory() . '/dist/css/' . $file_name . '/' . $file_name . '.css';

					if (file_exists($block_styles)) {
						$cache_bust = '?' . filemtime($block_styles);
						wp_enqueue_style($file_name, get_template_directory_uri() . '/dist/css/' . $file_name . '/' . $file_name . '.css', array(), $cache_bust);
					}
				}
			}
		});
	}

	/* ACF Block Class/ID Helper Function */
	function block_class_id($block_entry, $class) {
		$className = $class;

		if (!empty($block_entry['anchor'])) {
			$id = $block_entry['anchor'];
		}
		if (!empty($block_entry['className'])) {
			$className .= ' ' . $block_entry['className'];
		}

		$output = 'class="' . esc_attr($className) . '"';
		if (isset($id)) {
			$output .= 'id="' . esc_attr($id) . '"';
		}

		echo $output;
	}

	/* Get Block Field  */
	function blockFieldGroup($file) {
		$path = basename(dirname($file));
		$name = str_replace('-', '_', $path);
		$group = $name . '_group';

		return get_field($group);
	}

	/* Add Block Image Preview */
	function block_preview($blockpath) {
		$blockName = basename(dirname($blockpath));
		echo '<img data="block_preview" src="' . get_template_directory_uri() . '/parts/blocks/' . $blockName . '/' . $blockName . '.jpg" width="100%" height="auto">';
	}

	/* Init functions */
	acf_field_builder_registration();
	acf_components_field_builder_registration();
	acf_blocks_registration();
	acf_block_field_builder_registration();

	/* ACF Options Page */
	if (class_exists('ACF')) {
		acf_add_options_page(array(
			'page_title' => 'Globals',
			'menu_title' => 'Globals',
			'menu_slug' => 'my_globals',
			'capability' => 'edit_posts',
			'redirect' => false
		));
	}

/* Custom WYSIWYG toolbar */
add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
	$toolbars['Bold'] = [];
	$toolbars['Bold'][1] = ['bold']; // Add only bold button

	return $toolbars;
});