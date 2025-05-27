<?php
	add_action('admin_head', 'hide_editor');
	function hide_editor() {
		$template_file = basename(get_page_template());
		if ($template_file == 'page-about.php') {
			remove_post_type_support('page', 'editor');
		}
		if ((int) get_option('page_on_front') == get_the_ID()) {
			remove_post_type_support('page', 'editor');
		}
	}
