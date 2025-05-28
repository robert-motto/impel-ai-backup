<?php
	add_filter('allowed_block_types_all', 'motto_allowed_block_types');

	function motto_allowed_block_types($allowed_blocks) {
		global $post;
		$template_slug = get_page_template_slug($post->ID);
		if (
			(
				$post->post_type === 'page'
				&& $template_slug !== 'page-table-of-contents.php'
			)
			|| $post->post_type === 'wp_block'
		) {
			return array(
				'core/block',
				'acf/post-listing',
				'acf/featured-posts',
				'acf/hero',
				'acf/hero-secondary',
				'acf/content-block-left-right',
				'acf/content-block-left-right-with-metrics',
				'acf/before-after-comparison',
				'acf/general-metrics-section',
				'acf/integrations',
				'acf/single-media-section',
				'acf/simple-video',
				'acf/recent-posts',
				'acf/logos-certification',
				'acf/tabs',
				'acf/grid-of-items',
				'acf/carousel-slider',
				'acf/testimonials',
				'acf/case-study-grid',
				'acf/main-cta',
				'acf/secondary-cta',
				'acf/tertiary-cta',
				'acf/shortlist',
				'acf/related-content',
				'acf/general-form',
				'acf/vertical-scrolling-cards',
				'acf/bento-grid',
				'acf/focus-scroll',
			);
		} else {
			return array(
				'core/paragraph',
				'core/heading',
				'core/image',
				'core/gallery',
				'core/video',
				'core/audio',
				'core/table',
				'core/separator',
				'core/spacer',
				'core/shortcode',
				'core/embed',
				'acf/single-post-content',
				'acf/single-post-content-with-bg',
				'acf/single-post-heading',
				'acf/single-post-subheading',
				'acf/single-post-quote',
				'acf/single-post-buttons',
				'acf/single-post-cta',
				'acf/single-post-cta-2',
			);
		}
	}
