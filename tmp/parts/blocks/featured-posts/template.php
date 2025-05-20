<?php /*
	Block Name: Featured Posts
	Block Align: center
	Block Icon: admin-post
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :
	$group = blockFieldGroup(__FILE__);

	global $featured_loaded_posts;

	$heading         = $group['heading_group'] ?? [];
	$post_type       = $group['post_type'] ?? 'post';
	$type_of_display = $group['type_of_display'] ?? 'newest';
	$posts           = $group['posts'] ?? [];

	if($type_of_display === 'newest' || empty($posts)) {
		$query_args = [
			'post_status'    => 'publish',
			'post_type'      => $post_type,
			'posts_per_page' => get_option('posts_per_rss'),
			'orderby'        => 'date',
			'order'          => 'DESC',
			'fields'         => 'ids'
		];
		$the_query = new WP_Query($query_args);
		$posts     = $the_query->posts;
	}

	$featured_loaded_posts = $posts;

	if(!empty($posts)):
?>
		<section <?php echo section_settings_id($group); ?> class="l-section l-section--featured-posts <?php echo section_settings_mode_classes($group); ?>" data-block="featured-posts">
			<div class="featured-posts l-wrapper">
				<?php
					get_component('breadcrumbs', [
						'classes' => 'featured-posts__breadcrumbs',
					]);
				?>
				<div class="featured-posts-hld <?php echo section_settings_padding_classes($group);?>">
					<?php
						get_acf_component('heading', [
							'data'    => $heading,
							'classes' => 'featured-posts__heading',
						]);
					?>
					<div class="featured-posts__posts">
						<?php
							get_component('posts/items/large', [
								'post_id' => $posts[0],
								'classes' => 'featured-posts__large-post',
							]);
						?>
						<?php if(count($posts) > 1) : ?>
							<div class="featured-posts__small-posts">
								<?php foreach($posts as $post) : ?>
									<?php
										if($post !== $posts[0]) {
											get_component('posts/items/small', [
												'post_id' => $post,
												'classes' => 'featured-posts__small-post',
											]);
										}
									?>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
		<style>
			<?php
				echo file_get_contents(get_template_directory() . '/dist/css/featured-posts/featured-posts.css');
			?>
		</style>
	<?php endif; ?>
<?php endif; ?>
