<?php
	$menu_type = get_field('menu_type') ?? 'is-dark';
?>
<header class="site-top js-header <?php echo $menu_type; ?>" type="<?php echo $menu_type; ?>">
	<div class="l-wrapper">
		<a class="site-top__logo" href="<?php echo get_home_url(); ?>" title="<?php _e('Go to home', get_option('template')); ?>">
			<?php
				$logo = get_field('logo', 'options');
				if($logo) {
					echo file_get_contents($logo);
				}
				else{
					get_icon('logo');
				}
			?>
		</a>
		<div class="site-top__nav">
			<?php
				wp_nav_menu(array(
					'theme_location' => 'main_menu',
					'menu_class'     => 'site-top-nav',
					'container'      => false,
					'link_class'     => 'site-top-nav__item',
					'link_before'    => '<span class="text" data-title="%s">',
					'link_after'     => '</span>',
					'walker'         => new WPSE_78121_Sublevel_Walker,
				));
				$menu_buttons = get_field('menu_buttons', 'options')['buttons_group'];
				get_acf_component('buttons', [
					'data'    => $menu_buttons,
					'classes' => 'site-top__btns',
				]);
			?>
		</div>
		<button class="site-top__toggle-mobile js-mobile-nav-toggle">
			<span></span>
			<span></span>
			<span></span>
			<span class="u-sr-only"><?php _e('Open side navigation', get_option('template')); ?></span>
		</button>
	</div>
	<?php get_template_part('/parts/mobile-nav', null, [
		'menu_buttons' => $menu_buttons,
	]); ?>
</header>
