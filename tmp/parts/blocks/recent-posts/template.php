<?php /*
	Block Name: Recent posts
	Block Align: center
	Block Icon: clock
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>

	<?php
		$group        = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);

		$heading           = $group['heading_group'] ?? [];
		$content           = $group['content_group'] ?? [];
		$buttons           = $group['buttons_group'];
		$post_options      = $group['post_options_group'] ?? [];
		$has_description   = $post_options['has_description']  === 'y' ? true : false;
		$has_reading_time  = $post_options['has_reading_time'] === 'y' ? true : false;
		$post_type         = $group['post_type'] ?? 'post';
		$type_of_display   = $group['type_of_display'] ?? 'newest';
		$selected_posts    = $group['selected_posts'];

		if($type_of_display === 'newest' || empty($posts)) {
			$query_args = [
				'post_status'    => 'publish',
				'post_type'      => $post_type,
				'posts_per_page' => 3,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'fields'         => 'ids'
			];
			$the_query = new WP_Query($query_args);
			$selected_posts = $the_query->posts;
		}
	?>

	<section <?php echo section_settings_id($group); ?> class="l-section l-section--recent-posts <?php echo section_settings_classes($group); ?>" data-block="recent-posts">
		<div class="recent-posts l-wrapper">
			<div class="recent-posts__top">
				<div class="recent-posts__top-text">
					<?php
						get_acf_components([
							'heading' => [
								'data'    => $heading,
								'classes' => 'recent-posts__heading',
							],
							'content' => [
								'data'    => $content,
								'classes' => 'recent-posts__content',
							],
						]);
					?>
				</div>
				<?php if ($buttons) : ?>
					<div class="recent-posts__top-button">
						<?php get_acf_component('buttons', [
							'data'    => $buttons,
							'classes' => 'recent-posts__buttons',
						]); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if( $selected_posts ):
				$selected_count = count($selected_posts);
			?>
				<div class="recent-posts__items post-items__grid is-items-<?php echo esc_attr($selected_count); ?>">
					<?php
						foreach( $selected_posts as $post ) {
							get_component('posts/items/default', [
								'post_id'          => $post,
								'has_description'  => $has_description,
								'has_reading_time' => $has_reading_time,
							]);
						}
					?>
				</div>
			<?php endif; ?>

		</div>
	</section>
<?php endif; ?>
