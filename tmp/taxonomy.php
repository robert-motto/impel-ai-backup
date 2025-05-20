<?php get_header(); ?>

<?php if (post_password_required()): ?>
	<?php the_content(); ?>
<?php else: ?>
	<?php
		$obj = get_queried_object();
		if($obj->taxonomy){
			$taxonomy = get_taxonomy($obj->taxonomy);
			$post_types = $taxonomy->object_type;
			if (!empty($post_types)) {
				$post_type = reset($post_types); // Get the first (and only) post type
				$page = get_page_by_path( $post_type );
				$post_id = $page->ID;
			}
		}
		if(empty($obj->name)){
			$post_id = get_queried_object_id();
		}

		$post = get_post($post_id);
		$blocks = parse_blocks($post->post_content);
		if ($blocks) {
			foreach ($blocks as $block) {
				echo render_block($block);
			}
		}
	?>
<?php endif; ?>

<?php get_footer(); ?>
