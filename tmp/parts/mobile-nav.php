<?php
	$header_logo = get_field('header_logo', 'options');
	$mobile_menu_1_intro = get_field('mobile_menu_1_intro', 'options') ?? [];
	$mobile_menu_2_intro = get_field('mobile_menu_2_intro', 'options') ?? [];
	$mobile_menu_3_intro = get_field('mobile_menu_3_intro', 'options') ?? [];
	$mobile_menu_4_intro = get_field('mobile_menu_4_intro', 'options') ?? [];
	$mobile_menu_5_intro = get_field('mobile_menu_5_intro', 'options') ?? [];
	$header_button = get_field('header_button', 'options');
	$global_dropdown_data = get_field('global_dropdown', 'options') ?? [];
	$login_dropdown_data = get_field('login_dropdown', 'options') ?? [];
	$menu_buttons = get_field('menu_buttons', 'options')['buttons_group'] ?? [];

	function get_mobile_menu_title($menu_location) {
		$locations = get_nav_menu_locations();
		if (isset($locations[$menu_location])) {
			$menu = wp_get_nav_menu_object($locations[$menu_location]);
			return $menu ? $menu->name : '';
		}
		return '';
	}

	function render_mobile_submenu($menu_location, $classes = 'mobile-nav__subitem', $container = true) {
		if (has_nav_menu($menu_location)) {
			echo '<div class="mobile-nav__container">';
			wp_nav_menu(array(
				'theme_location' => $menu_location,
				'menu_class' => 'mobile-nav__submenu',
				'container' => $container,
				'link_class' => $classes,
				'link_before' => '<span class="content">',
				'link_after' => '</span>'
			));
			echo '</div>';
		}
	}

	function get_mobile_menu_items($menu_location) {
		$locations = get_nav_menu_locations();
		if (isset($locations[$menu_location])) {
			$menu_items = wp_get_nav_menu_items($locations[$menu_location]);
			return $menu_items ? $menu_items : [];
		}
		return [];
	}

	function render_mobile_intro_box($intro_data) {
		if (empty($intro_data['image']) && empty($intro_data['intro_text']) && empty($intro_data['link'])) {
			return '';
		}

		$output = '<div class="menu__post-box menu__post-box--orange menu__post-box--mobile intro-box">';
		$output .= '<div class="intro-box__container">';

		if (!empty($intro_data['image'])) {
			$output .= '<img class="intro-box__logo" src="' . esc_url($intro_data['image']['url']) . '" alt="">';
		}

		if (!empty($intro_data['intro_text'])) {
			$output .= '<div class="intro-box__content t-paragraph--3">' . $intro_data['intro_text'] . '</div>';
		}

		if (!empty($intro_data['link']['url']) && !empty($intro_data['link']['title'])) {
			$output .= '<div class="intro-box__link-hld">';
			$output .= '<a class="intro-box__link u-link" href="' . esc_url($intro_data['link']['url']) . '">';
			$output .= '<span class="text t-button--3">' . esc_html($intro_data['link']['title']) . '</span>';
			$output .= '<span class="icon">';
			$output .= '<svg class="svg-arrow-right" viewBox="0 0 20 20">';
			$output .= '<path d="M4.16675 10.0002H15.8334" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>';
			$output .= '<path d="M10.8333 15L15.8333 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>';
			$output .= '<path d="M10.8333 5L15.8333 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>';
			$output .= '</svg>';
			$output .= '</span>';
			$output .= '</a>';
			$output .= '</div>';
		}

		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
?>
<div class="mobile-nav-hld js-mobile-nav color-mode-is-light">
	<div class="mobile-nav-background js-mobile-nav-close"></div>
	<div class="mobile-nav-body">
		<div class="mobile-nav__main">
			<ul class="mobile-nav__menu">
				<!-- MOBILE MENU 1 (Why Impel) -->
				<?php
					$menu1_title = get_mobile_menu_title('mobile_menu_1');
					$menu1_items = get_mobile_menu_items('mobile_menu_1');
					if ($menu1_title && !empty($menu1_items)):
				?>
				<li class="mobile-nav__item">
					<div class="mobile-nav__parent js-mobile-nav-parent">
						<button class="text"><?php echo esc_html($menu1_title); ?></button>
						<svg class="svg-nav-arrow-down">
							<use xlink:href="#svg-nav-arrow-down"></use>
						</svg>
					</div>
					<div class="mobile-nav__sub">
						<?php echo render_mobile_intro_box($mobile_menu_1_intro); ?>
						<div class="mobile-nav__container">
							<ul class="mobile-nav__submenu">
								<?php foreach ($menu1_items as $item): ?>
									<li><a class="mobile-nav__subitem" href="<?php echo esc_url($item->url); ?>"><span class="content"><?php echo esc_html($item->title); ?></span></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</li>
				<?php endif; ?>

				<!-- MOBILE MENU 2 (PLATFORM) -->
				<?php
					$menu2_title = get_mobile_menu_title('mobile_menu_2');
					$menu2_items = get_mobile_menu_items('mobile_menu_2');
					if ($menu2_title && !empty($menu2_items)):
				?>
				<li class="mobile-nav__item">
					<div class="mobile-nav__parent js-mobile-nav-parent">
						<button class="text"><?php echo esc_html($menu2_title); ?></button>
						<svg class="svg-nav-arrow-down">
							<use xlink:href="#svg-nav-arrow-down"></use>
						</svg>
					</div>
					<div class="mobile-nav__sub">
						<?php echo render_mobile_intro_box($mobile_menu_2_intro); ?>
						<div class="mobile-nav__container">
							<ul class="mobile-nav__submenu">
								<?php foreach ($menu2_items as $item): ?>
									<li><a class="mobile-nav__subitem" href="<?php echo esc_url($item->url); ?>"><span class="content"><?php echo esc_html($item->title); ?></span></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</li>
				<?php endif; ?>

				<!-- MOBILE MENU 3 (SOLUTIONS) -->
				<?php
					$menu3_title = get_mobile_menu_title('mobile_menu_3');
					$menu3_items = get_mobile_menu_items('mobile_menu_3');
					if ($menu3_title && !empty($menu3_items)):
				?>
				<li class="mobile-nav__item">
					<div class="mobile-nav__parent js-mobile-nav-parent">
						<button class="text"><?php echo esc_html($menu3_title); ?></button>
						<svg class="svg-nav-arrow-down">
							<use xlink:href="#svg-nav-arrow-down"></use>
						</svg>
					</div>
					<div class="mobile-nav__sub">
						<?php echo render_mobile_intro_box($mobile_menu_3_intro); ?>
						<?php
							foreach ($menu3_items as $item) {
								if ($item->menu_item_parent == 0) {
									echo '<span class="mobile-nav__header t-caption">' . esc_html($item->title) . '</span>';
									$child_items = array_filter($menu3_items, function($child) use ($item) {
										return $child->menu_item_parent == $item->ID;
									});
									if (!empty($child_items)) {
										echo '<div class="mobile-nav__container">';
										echo '<ul class="mobile-nav__submenu mobile-nav__submenu--small">';
										foreach ($child_items as $child) {
											echo '<li><a class="mobile-nav__subitem mobile-nav__subitem--small" href="' . esc_url($child->url) . '"><span class="content content--small">' . esc_html($child->title) . '</span></a></li>';
										}
										echo '</ul>';
										echo '</div>';
									}
								}
							}
						?>
					</div>
				</li>
				<?php endif; ?>

				<!-- MOBILE MENU 4 (Resources) -->
				<?php
					$menu4_title = get_mobile_menu_title('mobile_menu_4');
					$menu4_items = get_mobile_menu_items('mobile_menu_4');
					if ($menu4_title && !empty($menu4_items)):
				?>
				<li class="mobile-nav__item">
					<div class="mobile-nav__parent js-mobile-nav-parent">
						<button class="text"><?php echo esc_html($menu4_title); ?></button>
						<svg class="svg-nav-arrow-down">
							<use xlink:href="#svg-nav-arrow-down"></use>
						</svg>
					</div>
					<div class="mobile-nav__sub">
						<?php echo render_mobile_intro_box($mobile_menu_4_intro); ?>
						<div class="mobile-nav__container">
							<ul class="mobile-nav__submenu">
								<?php foreach ($menu4_items as $item): ?>
									<li><a class="mobile-nav__subitem" href="<?php echo esc_url($item->url); ?>"><span class="content"><?php echo esc_html($item->title); ?></span></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</li>
				<?php endif; ?>

				<!-- MOBILE MENU 5 (Company) -->
				<?php
					$menu5_title = get_mobile_menu_title('mobile_menu_5');
					$menu5_items = get_mobile_menu_items('mobile_menu_5');
					if ($menu5_title && !empty($menu5_items)):
				?>
				<li class="mobile-nav__item">
					<div class="mobile-nav__parent js-mobile-nav-parent">
						<button class="text"><?php echo esc_html($menu5_title); ?></button>
						<svg class="svg-nav-arrow-down">
							<use xlink:href="#svg-nav-arrow-down"></use>
						</svg>
					</div>
					<div class="mobile-nav__sub">
						<?php echo render_mobile_intro_box($mobile_menu_5_intro); ?>
						<div class="mobile-nav__container">
							<ul class="mobile-nav__submenu">
								<?php foreach ($menu5_items as $item): ?>
									<li><a class="mobile-nav__subitem" href="<?php echo esc_url($item->url); ?>"><span class="content"><?php echo esc_html($item->title); ?></span></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</li>
				<?php endif; ?>

				<!-- GLOBAL DROPDOWN -->
				<?php if (!empty($global_dropdown_data['links'])): ?>
				<li class="mobile-nav__item">
					<div class="mobile-nav__parent js-mobile-nav-parent">
						<button class="text"><?php echo esc_html($global_dropdown_data['title'] ?? 'Global'); ?></button>
						<svg class="svg-nav-arrow-down">
							<use xlink:href="#svg-nav-arrow-down"></use>
						</svg>
					</div>
					<div class="mobile-nav__sub">
						<span class="mobile-nav__header t-caption"><?php echo esc_html($global_dropdown_data['description'] ?? 'Select your region and language.'); ?></span>
						<div class="mobile-nav__container">
							<ul class="mobile-nav__submenu">
								<?php foreach ($global_dropdown_data['links'] as $item): ?>
									<?php if (!empty($item['link']['url']) && !empty($item['link']['title'])): ?>
									<li>
										<a class="mobile-nav__subitem" href="<?php echo esc_url($item['link']['url']); ?>" <?php echo !empty($item['link']['target']) ? 'target="' . esc_attr($item['link']['target']) . '"' : ''; ?>>
											<span class="content"><?php echo esc_html($item['link']['title']); ?></span>
										</a>
									</li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</li>
				<?php endif; ?>

				<!-- LOGIN DROPDOWN -->
				<?php if (!empty($login_dropdown_data['links'])): ?>
				<li class="mobile-nav__item">
					<div class="mobile-nav__parent js-mobile-nav-parent">
						<button class="text"><?php echo esc_html($login_dropdown_data['title'] ?? 'Log In'); ?></button>
						<svg class="svg-nav-arrow-down">
							<use xlink:href="#svg-nav-arrow-down"></use>
						</svg>
					</div>
					<div class="mobile-nav__sub">
						<span class="mobile-nav__header t-caption"><?php echo esc_html($login_dropdown_data['description'] ?? 'Access your AI-powered tools and manage your account.'); ?></span>
						<div class="mobile-nav__container">
							<ul class="mobile-nav__submenu">
								<?php foreach ($login_dropdown_data['links'] as $item): ?>
									<?php if (!empty($item['link']['url']) && !empty($item['link']['title'])): ?>
									<li>
										<a class="mobile-nav__subitem" href="<?php echo esc_url($item['link']['url']); ?>" <?php echo !empty($item['link']['target']) ? 'target="' . esc_attr($item['link']['target']) . '"' : ''; ?>>
											<span class="content"><?php echo esc_html($item['link']['title']); ?></span>
										</a>
									</li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</li>
				<?php endif; ?>
			</ul>
		</div>
		<div class="mobile-nav__footer">
			<!-- Book a Demo Button -->
			<div class="footer__item t-paragraph">
				<div class="footer__btn-hld">
					<a class="footer__btn btn btn--primary" href="#">
						<span class="text">Book a Demo</span>
					</a>
				</div>
			</div>

			<!-- ACF Buttons from globals -->
			<?php if (!empty($menu_buttons) && !empty($menu_buttons[0]['button']['url'])): ?>
				<div class="footer__item t-paragraph">
					<div class="footer__btn-hld">
						<a class="footer__btn u-btn u-btn--narrow" href="<?php echo esc_url($menu_buttons[0]['button']['url']); ?>">
							<span class="text"><?php echo esc_html($menu_buttons[0]['button']['title']); ?></span>
						</a>
					</div>
				</div>
			<?php endif; ?>

			<!-- Original ACF Footer Buttons -->
			<?php if (is_array($header_button) && !empty($header_button['text1'])): ?>
				<div class="footer__item t-paragraph">
					<p class="footer__content t-interface--4"><?php echo esc_html($header_button['text1']); ?></p>
					<?php if (!empty($header_button['link1']) && is_array($header_button['link1'])): ?>
						<div class="footer__btn-hld">
							<a class="footer__btn u-btn u-btn--narrow u-btn--blue" href="<?php echo esc_url($header_button['link1']['url']); ?>">
								<span class="text"><?php echo esc_html($header_button['link1']['title']); ?></span>
							</a>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php if (is_array($header_button) && !empty($header_button['text2'])): ?>
				<div class="footer__item t-paragraph">
					<p class="footer__content t-interface--4"><?php echo esc_html($header_button['text2']); ?></p>
					<?php if (!empty($header_button['link2']) && is_array($header_button['link2'])): ?>
						<div class="footer__btn-hld">
							<a class="footer__btn u-btn u-btn--narrow" href="<?php echo esc_url($header_button['link2']['url']); ?>">
								<span class="text"><?php echo esc_html($header_button['link2']['title']); ?></span>
							</a>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
