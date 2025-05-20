<?php get_header(); ?>

<?php if (post_password_required()): ?>
	<?php the_content(); ?>
<?php else: ?>
	<?php
		$post_id = get_custom_queried_object_id();
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
