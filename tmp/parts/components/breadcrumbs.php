<?php
	$classes = $args['classes'] ?? '';

	if ( function_exists('yoast_breadcrumb') ) {
		// General breadcrumbs
		yoast_breadcrumb( '<p id="breadcrumbs" class="u-breadcrumbs '.$classes.'">','</p>' );
	}
?>

