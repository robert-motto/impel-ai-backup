<div class="mobile-nav-hld is-light js-mobile-nav">
	<div class="mobile-nav-body">
		<?php
			wp_nav_menu(array(
				'theme_location' => 'main_menu',
				'menu_class'     => 'mobile-nav',
				'container'      => false,
				'link_class'     => 'mobile-nav__item',
				'link_before'    => '<span class="text">',
				'link_after'     => '</span>',
				'walker'         => new WPSE_78121_Sublevel_Walker,
			));
			$menu_buttons = $args['menu_buttons'];
			get_acf_component('buttons', [
				'data'    => $menu_buttons,
				'classes' => 'mobile-nav__btns',
			]);
		?>

	</div>
</div>
