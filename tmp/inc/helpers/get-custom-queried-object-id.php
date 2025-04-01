<?php
	//Fix for preview mode
	function get_custom_queried_object_id() {
		$queried_object_id = get_queried_object_id();

		if (isset($_GET['preview']) && $_GET['preview'] === 'true') {
			// Get the post ID from the main query
			$post_id = $_GET['preview_id'];

			$last_revision = new WP_Query([
				'post_type'      => 'revision',
				'post_status'    => 'inherit', // 'inherit' or 'any
				'post_parent'    => $post_id,
				'posts_per_page' => 1,
				'orderby'        => 'ID',
				'order'          => 'DESC',
			]);

			// Return the custom object ID if a revision exists, otherwise return the original queried object ID
			return !empty($last_revision->posts) ? $last_revision->posts[0]->ID : $queried_object_id;
		}

		// If not in preview mode, return the original queried object ID
		return $queried_object_id;
	}
