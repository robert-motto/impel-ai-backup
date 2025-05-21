<?php
	$menu_type = get_field('menu_type') ?? 'is-dark';
?>
<header class="site-top js-header <?php echo esc_attr($menu_type); ?>" type="<?php echo esc_attr($menu_type); ?>">
	<div class="l-wrapper site-top__wrapper">
		<a class="site-top__logo" href="<?php echo esc_url(get_home_url()); ?>" title="<?php esc_attr_e('Go to home', get_option('template')); ?>">
			<?php
				$logo_url = get_field('logo', 'options');
				if ($logo_url) {
					$logo_path = '';
					if (filter_var($logo_url, FILTER_VALIDATE_URL)) {
						$parsed_url = wp_parse_url($logo_url);
						if (isset($parsed_url['path'])) {
							$potential_path = ABSPATH . ltrim($parsed_url['path'], '/');
							if (file_exists($potential_path) && str_ends_with(strtolower($potential_path), '.svg')) {
								echo file_get_contents($potential_path);
							} else {
								get_icon('logo');
							}
						} else {
							get_icon('logo');
						}
					} elseif ($logo_url) {
						if (file_exists($logo_url) && str_ends_with(strtolower($logo_url), '.svg')) {
							echo file_get_contents($logo_url);
						} else {
							get_icon('logo');
						}
					} else {
						get_icon('logo');
					}
				} else {
					get_icon('logo');
				}
			?>
		</a>
		<nav class="site-top__navigation">
			<?php
				wp_nav_menu(array(
					'theme_location' => 'main_menu',
					'menu_class'     => 'site-top__main-nav site-top-nav',
					'container'      => false,
					'link_class'     => 'site-top-nav__item',
					'link_before'    => '<span class="text">',
					'link_after'     => '</span>',
					'walker'         => new WPSE_78121_Sublevel_Walker,
				));
			?>
		</nav>
		<div class="site-top__actions">
			<a href="#" class="site-top__action-item site-top__action-item--global">
				<span class="site-top__action-icon site-top__action-icon--globe">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.99992 14.6666C11.6818 14.6666 14.6666 11.6818 14.6666 7.99992C14.6666 4.31802 11.6818 1.33325 7.99992 1.33325C4.31802 1.33325 1.33325 4.31802 1.33325 7.99992C1.33325 11.6818 4.31802 14.6666 7.99992 14.6666Z" stroke="#121212" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M5.33325 8.00001H10.6666" stroke="#121212" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.99992 1.33325C9.69029 3.5389 10.564 5.71173 10.6666 7.99992C10.564 10.2881 9.69029 12.4609 7.99992 14.6666C6.30955 12.4609 5.43573 10.2881 5.33325 7.99992C5.43573 5.71173 6.30955 3.5389 7.99992 1.33325V1.33325Z" stroke="#121212" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</span>
				<span class="text">Global</span>
				<span class="site-top__action-chevron">▾</span>
			</a>
			<a href="#" class="site-top__action-item">
				<span class="text">Log In</span>
				<span class="site-top__action-chevron">▾</span>
			</a>
			<a href="#" class="site-top__action-button btn btn--primary">Book a Demo</a>
			<?php
				$menu_buttons = get_field('menu_buttons', 'options')['buttons_group'] ?? [];
				if (!empty($menu_buttons) && !empty($menu_buttons[0]['button']['url'])) {
					echo '<div class="site-top__secondary-btns">';
					get_acf_component('buttons', [
						'data'    => $menu_buttons,
						'classes' => 'site-top__btns-acf',
					]);
					echo '</div>';
				}
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
