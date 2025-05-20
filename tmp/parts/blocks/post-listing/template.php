<?php /*
	Block Name: Post Listing
	Block Align: center
	Block Icon: grid-view
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		global $featured_loaded_posts;
		$group = blockFieldGroup(__FILE__);

		$no_found          = get_field('no_found', 'options');
		$post_type         = $group['post_type'];
		$hide_empty_cats   = $group['hide_empty_cats']         === 'y' ? true : false;
		$post_options      = $group['post_options_group'] ?? [];
		$has_description   = $post_options['has_description']  === 'y' ? true : false;
		$has_reading_time  = $post_options['has_reading_time'] === 'y' ? true : false;
		$heading           = $group['heading_group'] ?? [];
		$search_label      = $group['search_label'];
		$categories_label  = $group['categories_label'];
		$all_filters_label = $group['all_filters_label'];
		$tags_label        = $group['tags_label'];

		$order_options = [
			'newest' => [
				'label' => 'Newest to oldest',
				'value' => 'date',
				'order' => 'DESC',
			],
			'oldest' => [
				'label' => 'Oldest to newest',
				'value' => 'date',
				'order' => 'ASC',
			],
			'a-z' => [
				'label' => 'A-Z',
				'value' => 'title',
				'order' => 'ASC',
			],
			'z-a' => [
				'label' => 'Z-A',
				'value' => 'title',
				'order' => 'DESC',
			]
		];

		$order_by_query = isset($_GET['order_by']) ? $_GET['order_by'] : '';
		$order_by       = !empty($order_by_query) ? $order_by_query : 'newest';

		switch($post_type){
			case 'custom':
				$category_slug = 'custom_category';
				$tags_slug     = 'custom_tag';
				break;
			default:
				$category_slug = 'category';
				$tags_slug     = 'post_tag';
				break;
		}

		$categories = get_terms([
			'taxonomy'   => $category_slug,
			'hide_empty' => $hide_empty_cats,
		]);

		$tags = get_terms([
			'taxonomy'   => $tags_slug,
			'hide_empty' => $hide_empty_cats,
		]);

		$posts_per_page = get_option('posts_per_page');

		if (get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif (get_query_var('page')) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}

		$query_args = [
			'post_status'    => 'publish',
			'post_type'      => $post_type,
			'posts_per_page' => $posts_per_page,
			'post__not_in'   => $featured_loaded_posts,
			'orderby'        => $order_options[$order_by]['value'],
			'order'          => $order_options[$order_by]['order'],
			'paged'          => $paged,
			'fields'         => 'ids'
		];

		$search_phrase = isset($_GET['search']) ? $_GET['search'] : '';

		if(!empty($search_phrase)){
			$query_args['s'] = $search_phrase;
		}

		$current_object = get_queried_object();
		$current_cat_slug = '';
		$all_posts_link = get_the_permalink();
		$current_url_with_cats = $all_posts_link;

		if(!empty($current_object->taxonomy)){
			$current_cat_slug = $current_object->slug;
			$query_args['tax_query'][] = [
				'taxonomy' => $current_object->taxonomy,
				'field'    => 'term_id',
				'terms'    => $current_object->term_id,
			];
			$current_url_with_cats .= $current_cat_slug.'/';
		}

		$current_tag_slug = isset($_GET['topic']) ? $_GET['topic'] : '';

		if(!empty($current_tag_slug)){
			$query_args['tax_query'][] = [
				'taxonomy' => $tags_slug,
				'field'    => 'slug',
				'terms'    => $current_tag_slug,
			];
		}

		$the_query = new WP_Query($query_args);
		$posts = $the_query->posts;

	?>
	<section <?php echo section_settings_id($group); ?> class="l-section l-section--post-listing js-filters-hld js-filter-body u-filter-body <?php echo section_settings_classes($group); ?>" data-block="post-listing">
		<div class="post-listing l-wrapper">
			<div class="u-filter-body-to-load js-filter-body-to-load">
				<div class="post-listing__header-hld u-wrapper">
					<?php
						get_acf_component('heading', [
							'data'    => $heading,
							'classes' => 'post-listing__heading',
						]);
					?>
					<div class="post-listing__top-filters-hld">
						<?php
							get_components([
								'posts/search' => [
									'classes'      => '',
									'search_label' => $search_label,
								],
								'select' => [
									'id'            => 'order-select-dropdown',
									'classes'       => '',
									'order_options' => $order_options,
									'active_order'  => $order_by,
									'js_classes'    => 'js-order-select-option',
								],
							]);
						?>
					</div>
				</div>
				<div class="post-listing__filters-grid">
					<?php
						get_components([
							'posts/categories-filters' => [
								'categories'        => $categories,
								'current_cat_slug'  => $current_cat_slug,
								'current_object'    => $current_object,
								'categories_label'  => $categories_label,
								'all_filters_label' => $all_filters_label,
								'all_posts_link'    => $all_posts_link,
								'search_phrase'     => $search_phrase,
								'current_tag_slug'  => $current_tag_slug,
								'order_by'          => $order_by_query,
							],
							'posts/tags-filters' => [
								'tags'               => $tags,
								'tags_taxonomy_slug' => $tags_slug,
								'current_tag_slug'   => $current_tag_slug,
								'tags_label'         => $tags_label,
								'all_filters_label'  => $all_filters_label,
								'base_url'           => $current_url_with_cats,
								'search_phrase'      => $search_phrase,
								'order_by'           => $order_by_query,
							],
						]);
					?>
				</div>
				<?php
					if(empty($posts)) :
						get_component( 'posts/no-found', [
							'classes' => 'u-wrapper',
							'data'    => $no_found,
						]);
					else :
				?>

					<div class="post-items__grid u-wrapper">
						<?php
							foreach($posts as $post){
								get_component('posts/items/default', [
									'post_id'          => $post,
									'has_description'  => $has_description,
									'has_reading_time' => $has_reading_time,
								]);
							}
						?>
					</div>
					<?php
						get_component('base-post-pagination', [
							'total_number_of_pages' => $the_query->max_num_pages,
							'posts_per_page'        => $posts_per_page,
							'classes'               => 'post-listing__pagination',
						]);
					?>
				<?php endif; ?>
			</div>
		</div>
		<div class="u-filter-loader">
			<?php
				get_icon('loading-animated', [
					'classes' => 'u-filter-loader__icon',
				]);
			?>
		</div>
	</section>
<?php endif; ?>
