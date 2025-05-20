<?php

	function get_reusable_block($block_name){
        $block_id = get_posts([
            'post_type' => 'wp_block',
            'name' => sanitize_title($block_name),
            'posts_per_page' => 1,
            'fields' => 'ids'
        ])[0];
        if($block_id){
            $block_content = apply_filters('the_content', get_post_field('post_content', $block_id));
			return $block_content;
		}
		return null;
	}
