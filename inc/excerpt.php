<?php
	function custom_excerpt_length($length) {
		return 20;
	}
	add_filter('excerpt_length', 'custom_excerpt_length', 999);
	function wpdocs_excerpt_more($more) {
		return '...';
	}
	add_filter('excerpt_more', 'wpdocs_excerpt_more');

	function excerpt($limit) {
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt) >= $limit) {
			array_pop($excerpt);
			$excerpt = implode(" ", $excerpt) . '...';
		} else {
			$excerpt = implode(" ", $excerpt);
		}
		$excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
		return $excerpt;
	}

