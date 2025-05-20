<?php get_header(); ?>

<?php if (post_password_required()): ?>
	<?php the_content(); ?>
<?php else: ?>
	<?php
		$post_type = get_post_type();
		switch($post_type) {
			case 'post':
				$post = get_page_by_path('blog');
				break;
			default:
				$post = get_page_by_path($post_type);
				break;
		}
		$blocks = parse_blocks($post->post_content);
		if ($blocks) {
			foreach ($blocks as $block) {
				echo render_block($block);
			}
		}
	?>
<?php endif; ?>

<?php get_footer(); ?>
