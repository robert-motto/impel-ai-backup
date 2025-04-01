<?php
	add_action('wp_ajax_nopriv_rk_function', 'rk_ajax_function');
	add_action('wp_ajax_rk_function', 'rk_ajax_function');
	function rk_ajax_function(){
		// $test = $_POST['test'];
		// $args = array(
		//     'posts_per_page' => -1,
		//     'product_cat' => $category,
		//     'post_type' => 'product',
		//     'orderby' => 'date',
		//     'order'   => 'ASC',
		//);
		// $the_query = new WP_Query($args);
		// if(($the_query->have_posts())) {
		// $response = '<div class="product-list"><div class="row">';
		//   while ($the_query->have_posts()) {
		//       $the_query->the_post();
		//       $title = get_the_title();
		//       $link = get_permalink();
		//       $img_url = get_field('product_featured_image');
		//       $response .= '<div class="col-6 col-md-4 product">';
		//       $response .= '<a href="' . $link . '">';
		//       $response .= '<div class="product-img-container rocket-lazyload"  data-bg="url(' . $img_url . ')" ></div>';
		//       $response .= '</a>';
		//       $response .= '<p class="product-title">' . $title . '</p>';
		//       $response .= '</div>';
		//   }
		//   $response .= '</div></div>';
		// } else {
		//   $response = '<p>No products found in this category</p>';
		// }
		// echo $response;
		// wp_reset_postdata();
		// die();
		echo 'ajax works: ' . $test;
		die();
	}
