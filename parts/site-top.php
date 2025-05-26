<?php
	$menu_type = get_field('menu_type') ?? 'is-dark';
	$top_bar_data = get_field('top_bar', 'options') ?? [];
	$show_top_bar = $top_bar_data['show_top_bar'] ?? false;
	$top_bar_message = $top_bar_data['top_bar_message'] ?? '';
	$top_bar_link = $top_bar_data['top_bar_link'] ?? [];
?>
<header class="site-top color-mode-is-light js-header <?php echo esc_attr($menu_type); ?>" type="<?php echo esc_attr($menu_type); ?>">
	<?php if ($show_top_bar && !empty($top_bar_message)): ?>
		<div class="site-top__notification-bar js-notification-bar">
			<div class="l-wrapper site-top__notification-bar-wrapper">
				<div class="site-top__notification-bar-content">
					<span class="site-top__notification-bar-message"><?php echo esc_html($top_bar_message); ?></span>
					<?php if (!empty($top_bar_link['url']) && !empty($top_bar_link['title'])): ?>
						<a href="<?php echo esc_url($top_bar_link['url']); ?>" class="site-top__notification-bar-link" <?php echo !empty($top_bar_link['target']) ? 'target="' . esc_attr($top_bar_link['target']) . '"' : ''; ?>>
							<?php echo esc_html($top_bar_link['title']); ?>
						</a>
					<?php endif; ?>
				</div>
				<button class="site-top__notification-bar-close js-notification-bar-close" aria-label="<?php esc_attr_e('Close notification', get_option('template')); ?>">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 4L4 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M4 4L12 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</button>
			</div>
		</div>
	<?php endif; ?>
	<div class="l-wrapper site-top__wrapper js-main-bar-hld">
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
			<div class="site-top__action-group">
				<a href="#" class="site-top__action-item site-top__action-item--global js-global-toggle">
					<span class="site-top__action-icon site-top__action-icon--globe">
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.99992 14.6666C11.6818 14.6666 14.6666 11.6818 14.6666 7.99992C14.6666 4.31802 11.6818 1.33325 7.99992 1.33325C4.31802 1.33325 1.33325 4.31802 1.33325 7.99992C1.33325 11.6818 4.31802 14.6666 7.99992 14.6666Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M5.33325 8.00001H10.6666" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.99992 1.33325C9.69029 3.5389 10.564 5.71173 10.6666 7.99992C10.564 10.2881 9.69029 12.4609 7.99992 14.6666C6.30955 12.4609 5.43573 10.2881 5.33325 7.99992C5.43573 5.71173 6.30955 3.5389 7.99992 1.33325V1.33325Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</span>
					<span class="text">Global</span>
					<span class="site-top__action-chevron">▾</span>
				</a>
				<div class="site-top__dropdown site-top__dropdown--global js-global-dropdown">
					<?php
						$global_dropdown_data = get_field('global_dropdown', 'options') ?? [];
						$global_dropdown_title = $global_dropdown_data['title'] ?? 'Website Location';
						$global_dropdown_description = $global_dropdown_data['description'] ?? 'Select your region and language.';
						$global_dropdown_links = $global_dropdown_data['links'] ?? [
							['link' => ['url' => '#', 'title' => 'North America (EN)']],
							['link' => ['url' => '#', 'title' => 'Europe (EN)']],
							['link' => ['url' => '#', 'title' => 'Asia (EN)']],
						];

						if ($global_dropdown_links): ?>
							<div class="site-top__dropdown-content-wrapper">
								<div class="site-top__dropdown-info">
									<?php if ($global_dropdown_title): ?>
										<h3 class="site-top__dropdown-info-title"><?php echo esc_html($global_dropdown_title); ?></h3>
									<?php endif; ?>
									<?php if ($global_dropdown_description): ?>
										<p class="site-top__dropdown-info-description"><?php echo esc_html($global_dropdown_description); ?></p>
									<?php endif; ?>
								</div>
								<ul class="site-top__dropdown-list">
									<?php foreach ($global_dropdown_links as $item): ?>
										<?php
											$link = $item['link'] ?? [];
											if (empty($link['url']) || empty($link['title'])) continue;
										?>
										<li>
											<a href="<?php echo esc_url($link['url']); ?>" <?php echo !empty($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
												<?php echo esc_html($link['title']); ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
				</div>
			</div>
			<div class="site-top__action-group">
				<a href="#" class="site-top__action-item js-login-toggle">
					<span class="text">Log In</span>
					<span class="site-top__action-chevron">▾</span>
				</a>
				<div class="site-top__dropdown site-top__dropdown--login js-login-dropdown">
					<?php
						$login_dropdown_data = get_field('login_dropdown', 'options') ?? [];
						$login_dropdown_title = $login_dropdown_data['title'] ?? 'Log In';
						$login_dropdown_description = $login_dropdown_data['description'] ?? 'Access your AI-powered tools and manage your account.';
						$login_dropdown_links = $login_dropdown_data['links'] ?? [
							['link' => ['url' => '#', 'title' => 'Sales AI Copilot']],
							['link' => ['url' => '#', 'title' => 'Chat AI']],
							['link' => ['url' => '#', 'title' => 'Service AI']],
							['link' => ['url' => '#', 'title' => '360 Manager']],
						];

						if ($login_dropdown_links): ?>
							<div class="site-top__dropdown-content-wrapper">
								<div class="site-top__dropdown-info">
									<?php if ($login_dropdown_title): ?>
										<h3 class="site-top__dropdown-info-title"><?php echo esc_html($login_dropdown_title); ?></h3>
									<?php endif; ?>
									<?php if ($login_dropdown_description): ?>
										<p class="site-top__dropdown-info-description"><?php echo esc_html($login_dropdown_description); ?></p>
									<?php endif; ?>
								</div>
								<ul class="site-top__dropdown-list">
									<?php foreach ($login_dropdown_links as $item): ?>
										<?php
											$link = $item['link'] ?? [];
											if (empty($link['url']) || empty($link['title'])) continue;
										?>
										<li>
											<a href="<?php echo esc_url($link['url']); ?>" <?php echo !empty($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
												<?php echo esc_html($link['title']); ?>
												<span class="site-top__dropdown-arrow">
													<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>
												</span>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
				</div>
			</div>
			<a href="#" class="btn btn--primary site-top__action-button btn btn--primary">Book a Demo</a>
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
