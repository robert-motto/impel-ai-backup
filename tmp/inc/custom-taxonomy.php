<?php
	/**
	 * Register custom post type
	 *
	 * @param string $name
	 * @param string $slug
	 * @param array $supports
	 * @param bool $exclude_from_search
	 */
	function rk_register_post_type_visible($name, $slug, $supports, $exclude_from_search = false, $dashicon, $add, $menu_position, $publicly_queryable = true) {
		$labels = [
			'name' => ucfirst($name),
			'singular_name' => ucfirst($name),
			'add_new' => __($add, get_option('template')),
			'add_new_item' => __('Add Item', get_option('template')),
			'edit_item' => __('Edit', get_option('template')),
			'new_item' => __('New', get_option('template')),
			'view_item' => __('View', get_option('template')),
			'search_items' => __('Search', get_option('template')),
			'not_found' => __('Not found', get_option('template')),
			'not_found_in_trash' => __('Not found', get_option('template')),
			'parent_item_colon' => ''
		];
		$args = [
			'labels' => $labels,
			'public' => true,
			'exclude_from_search' => $exclude_from_search,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'rewrite' => [
				'slug' => $slug,
				'with_front' => false,
			],
			'supports' => $supports,
			'menu_icon' => $dashicon,
			'show_in_rest' => true,
			'has_archive' => true,
			'taxonomies' => ['category'],
			'menu_position' => $menu_position,
			'publicly_queryable' => $publicly_queryable,
		];
		register_post_type(strtolower($slug), $args);
	}
	/**
	 * Register custom taxonomy
	 *
	 * @param string $name
	 * @param string $slug
	 * @param string $posttype
	 * @param bool $hierarchical
	 * @param bool $rewrite_slug
	 */

	function rk_register_taxonomy($name, $slug, $posttype, $hierarchical = true, $rewrite_slug = false) {
		if (!is_array($posttype)) {
			$posttype = array($posttype);
		}
		if($rewrite_slug === false) {
			$rewrite_slug = strtolower($slug);
		}
		register_taxonomy($slug, $posttype, [
				'hierarchical' => $hierarchical,
				'label' => $name,
				'singular_label' => ucfirst($name),
				'show_in_rest' => true,
				'rewrite' => [
					'slug' => $rewrite_slug,
					'hierarchical' => true,
					'with_front' => false,
				]
			],);
	}

	/**
	 * Add custom columns for post types
	 *
	 * @param string $post_type
	 * @param array $new_columns
	 * @param array $taxonomies if columns slug match taxonomies you can live this empty
	 * @return void
	 */
	function rk_register_custom_columns($post_type, $new_columns, $taxonomies = []) {
		/**
		 * Add custom columns for post types
		 *
		 * @param array $columns
		 * @return array
		 */
		$add_custom_columns = function($columns) use ($new_columns) {
			foreach ($new_columns as $key => $value) {
				$columns[$key] = $value;
			}
			return $columns;
		};

		/**
		 * Fill custom columns for post types
		 *
		 * @param string $column
		 * @param int $post_id
		 */
		$fill_custom_column = function($column, $post_id) use ($new_columns, $taxonomies) {
			if (empty($taxonomies)) {
				$taxonomies = array_keys($new_columns);
			}
			if (in_array($column, $taxonomies)) {
				$term_list = get_the_term_list($post_id, $column, '', ', ', '');
				if (!is_wp_error($term_list) && $term_list) {
					echo $term_list;
				} else {
					echo '-';
				}
			}
		};

		add_filter("manage_{$post_type}_posts_columns", $add_custom_columns);
		add_action("manage_{$post_type}_posts_custom_column", $fill_custom_column, 10, 2);
	}

	// CUSTOM POST TYPE
	rk_register_post_type_visible('Custom Posts', 'custom', ['title', 'editor', 'thumbnail'], true, 'dashicons-text-page', 'Add custom post', 6);
	// CUSTOM CATEGORIES FOR CUSTOM POST
	rk_register_taxonomy('Custom Post categories', 'custom_category', ['custom'], true, 'custom-category');
	rk_register_taxonomy('Custom Post tags', 'custom_tag', ['custom'], false);
	rk_register_custom_columns('custom', [
		'custom_category' => 'Categories',
		'custom_tag' => 'Tags'
	]);
	add_theme_support('post-thumbnails'); // add featured image to custom taxonomy







