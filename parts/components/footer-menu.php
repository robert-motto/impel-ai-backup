<?php
	$locations = get_nav_menu_locations();
	$menu_name = $args['menu_name'];
	$classes = $args['classes'] ?? '';
	$menu = isset($locations[$menu_name]) ? wp_get_nav_menu_object($locations[$menu_name]) : false;
?>
<div class="site-footer__menu <?php echo $classes; ?>">
	<?php
		if ($menu) {
			echo '<span class="site-footer-nav__title t-caption t-caption--1">'.$menu->name.'</span>';
			wp_nav_menu(array(
				'theme_location' => $menu_name,
				'menu_class' => 'site-footer-nav',
				'container' => false,
				'link_class'   => 'site-footer-nav__item',
				'link_before' => '<span class="text">',
				'link_after' => '</span>',
				'walker' => new WPSE_78121_Sublevel_Walker,
			));
		} else {
			// Optional: Show a message for admin users that this menu needs to be set up
			if (current_user_can('manage_options')) {
				echo '<div class="site-footer-nav__message">Menu "' . esc_html($menu_name) . '" not found. Please set up this menu in WordPress admin (Appearance > Menus -> Manage Locations)</div>';
			}
		}
	?>
</div>
