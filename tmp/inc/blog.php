<?php
	add_action('pre_get_posts', 'sbg_query_offset', 1);
	function sbg_query_offset($query) {
		$offset = 1;
		$ppp = get_option('posts_per_page');
		if (!is_admin() && $query->is_main_query()) {
			if ($query->is_paged) {
				$page_offset = $offset + (($query->query_vars['paged'] - 1) * $ppp);
				$query->set('offset', $page_offset);
			} else {
				$query->set('offset', $offset);
			}
		}
	}

	/* Filter function to be used with number_format_i18n filter hook */
	if (!function_exists('wpse255124_zero_prefix')) :
		function wpse255124_zero_prefix($format) {
			$number = intval($format);
			if (intval($number / 10) > 0) {
				return $format;
			}
			return '0' . $format;
		}
	endif;

	/**
	* Rename default post type to Blog
	*
	* @param object $labels
	* @hooked post_type_labels_post
	* @return object $labels
	*/
	function rename_labels( $labels )
	{
		# Labels
		$labels->name = 'Blog';
		$labels->singular_name = 'Blog';
		$labels->add_new = 'Add post';
		$labels->add_new_item = 'Add post';
		$labels->edit_item = 'Edit post';
		$labels->new_item = 'New post';
		$labels->view_item = 'View post';
		$labels->view_items = 'View post';
		$labels->search_items = 'Search post';
		$labels->not_found = 'No post found.';
		$labels->not_found_in_trash = 'No post found in Trash.';
		$labels->parent_item_colon = 'Parent post'; // Not for "post"
		$labels->archives = 'Blog Archives';
		$labels->attributes = 'Blog Attributes';
		$labels->insert_into_item = 'Insert into post';
		$labels->uploaded_to_this_item = 'Uploaded to this post';
		$labels->featured_image = 'Featured Image';
		$labels->set_featured_image = 'Set featured image';
		$labels->remove_featured_image = 'Remove featured image';
		$labels->use_featured_image = 'Use as featured image';
		$labels->filter_items_list = 'Filter Blog list';
		$labels->items_list_navigation = 'Blog list navigation';
		$labels->items_list = 'Blog list';
		$labels->items_list = 'Blog list';

		# Menu
		$labels->menu_name = 'Blog';
		$labels->all_items = 'All posts';
		$labels->name_admin_bar = 'Blog';
		return $labels;
	}

	function change_post_menu_label_icon() {
		global $menu;
		$menu[5][0] = 'Blog';
		$menu[5][6] = 'dashicons-editor-bold';
	}
	add_action( 'admin_menu', 'change_post_menu_label_icon' );

