<?php
	$header_logo = get_field('header_logo', 'options');
	$first_dropdown = get_field('first_dropdown', 'options');
	$first_post = get_field('first_post', 'options');
	$second_dropdown = get_field('second_dropdown', 'options');
	$second_post = get_field('second_post', 'options');
	$third_dropdown = get_field('third_dropdown', 'options');
	$third_post = get_field('third_post', 'options');
	$fourth_dropdown = get_field('fourth_dropdown', 'options');
	$fourth_post = get_field('fourth_post', 'options');
	$menu_link = get_field('menu_link', 'options');
	$cloud_image = get_field('cloud_image', 'options');
	$cloud_intro = get_field('cloud_intro', 'options');
	$cloud_link = get_field('cloud_link', 'options');
	$cloud_industry = get_field('cloud_industry', 'options');
	$consulting_image = get_field('consulting_image', 'options');
	$consulting_intro = get_field('consulting_intro', 'options');
	$consulting_link = get_field('consulting_link', 'options');
	$consulting_solution = get_field('consulting_solution', 'options');
	$consulting_industry = get_field('consulting_industry', 'options');
	$header_button = get_field('header_button', 'options');
?>
<div class="mobile-nav-hld js-mobile-nav">
	<div class="mobile-nav-background js-mobile-nav-close"></div>
	<div class="mobile-nav-body">
		<div class="mobile-nav__main">
			<ul class="mobile-nav__menu">
				<!-- FIRST DROPDOWN -->
				<li class="mobile-nav__item">
					<div class="mobile-nav__parent">
						<button class="text"><?php echo $first_dropdown; ?></button>
						<svg class="svg-nav-arrow-down">
							<use xlink:href="#svg-nav-arrow-down"></use>
						</svg>
					</div>
					<div class="mobile-nav__sub">
						<span class="mobile-nav__header t-caption">Learn</span>
						<?php if (has_nav_menu('company_learn_menu')): ?>
							<div class="mobile-nav__container">
								<?php
									wp_nav_menu(array(
										'theme_location' => 'company_learn_menu',
										'menu_class' => 'mobile-nav__submenu',
										'container' => true,
										'link_class'   => 'mobile-nav__subitem',
										'link_before' => '<span class="content">',
										'link_after' => '</span>'
									));
								?>
							</div>
						<?php endif; ?>
						<span class="mobile-nav__header t-caption">Engage</span>
						<?php if (has_nav_menu('company_engage_menu')): ?>
							<div class="mobile-nav__container">
								<?php
									wp_nav_menu(array(
										'theme_location' => 'company_engage_menu',
										'menu_class' => 'mobile-nav__submenu',
										'container' => true,
										'link_class'   => 'mobile-nav__subitem',
										'link_before' => '<span class="content">',
										'link_after' => '</span>'
									));
								?>
							</div>
						<?php endif; ?>
					</div>
				</li>
				<!-- SECOND DROPDOWN -->
				<li class="mobile-nav__item">
					<div class="mobile-nav__parent">
						<button class="text"><?php echo $second_dropdown; ?></button>
						<svg class="svg-nav-arrow-down">
							<use xlink:href="#svg-nav-arrow-down"></use>
						</svg>
					</div>
					<div class="mobile-nav__sub">
						<div class="menu__post-box menu__post-box--blue menu__post-box--mobile intro-box">
							<div class="intro-box__container">
								<img class="intro-box__logo" src="<?php echo $cloud_image['url'] ?>">
								<div class="intro-box__content t-paragraph--3"><?php echo $cloud_intro ?></div>
								<div class="intro-box__link-hld">
									<a class="intro-box__link u-link" href="<?php echo $cloud_link['url'] ?>">
										<span class="text t-button--3"><?php echo $cloud_link['title'] ?></span>
										<span class="icon">
											<svg class="svg-arrow-right" viewBox="0 0 20 20">
												<path d="M4.16675 10.0002H15.8334" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M10.8333 15L15.8333 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M10.8333 5L15.8333 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</span>
									</a>
								</div>
							</div>
						</div>
						<span class="mobile-nav__header t-caption">By solution</span>
						<?php if (has_nav_menu('cloud_solution_1_menu')): ?>
							<div class="mobile-nav__container">
								<?php
									wp_nav_menu(array(
										'theme_location' => 'cloud_solution_1_menu',
										'menu_class' => 'mobile-nav__submenu',
										'container' => true,
										'link_class'   => 'mobile-nav__subitem no-sub-menu',
										'link_before' => '<span class="content">',
										'link_after' => '</span>'
									));
								?>
							</div>
						<?php endif; ?>
						<?php if (has_nav_menu('cloud_solution_2_menu')): ?>
							<div class="mobile-nav__container">
								<?php
									wp_nav_menu(array(
										'theme_location' => 'cloud_solution_2_menu',
										'menu_class' => 'mobile-nav__submenu',
										'container' => true,
										'link_class'   => 'mobile-nav__subitem no-sub-menu',
										'link_before' => '<span class="content">',
										'link_after' => '</span>'
									));
								?>
							</div>
						<?php endif; ?>
						<?php if (has_nav_menu('cloud_solution_3_menu')): ?>
							<div class="mobile-nav__container">
								<?php
									wp_nav_menu(array(
										'theme_location' => 'cloud_solution_3_menu',
										'menu_class' => 'mobile-nav__submenu',
										'container' => true,
										'link_class'   => 'mobile-nav__subitem no-sub-menu',
										'link_before' => '<span class="content">',
										'link_after' => '</span>'
									));
								?>
							</div>
						<?php endif; ?>
						<span class="mobile-nav__header t-caption">By industry</span>
						<?php if (has_nav_menu('cloud_industry_menu')): ?>
							<div class="mobile-nav__container">
								<div class="mobile-nav__info"><?php echo $cloud_industry; ?></div>
								<?php
									wp_nav_menu(array(
										'theme_location' => 'cloud_industry_menu',
										'menu_class' => 'mobile-nav__submenu mobile-nav__submenu--small',
										'container' => false,
										'link_class'   => 'mobile-nav__subitem mobile-nav__subitem--small',
										'link_before' => '<span class="content content--small">',
										'link_after' => '</span>'
									));
								?>
							</div>
						<?php endif; ?>
					</div>
				</li>
				<!-- THIRD DROPDOWN -->
				<li class="mobile-nav__item">
					<div class="mobile-nav__parent">
						<button class="text"><?php echo $third_dropdown; ?></button>
						<svg class="svg-nav-arrow-down">
							<use xlink:href="#svg-nav-arrow-down"></use>
						</svg>
					</div>
					<div class="mobile-nav__sub">
						<div class="menu__post-box menu__post-box--orange menu__post-box--mobile intro-box">
							<div class="intro-box__container">
								<img class="intro-box__logo" src="<?php echo $consulting_image['url'] ?>">
								<div class="intro-box__content t-paragraph--3"><?php echo $consulting_intro ?></div>
								<div class="intro-box__link-hld">
									<a class="intro-box__link u-link" href="<?php echo $consulting_link['url'] ?>">
										<span class="text t-button--3"><?php echo $consulting_link['title'] ?></span>
										<span class="icon">
											<svg class="svg-arrow-right" viewBox="0 0 20 20">
												<path d="M4.16675 10.0002H15.8334" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M10.8333 15L15.8333 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M10.8333 5L15.8333 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</span>
									</a>
								</div>
							</div>
						</div>
						<span class="mobile-nav__header t-caption">By solution</span>
						<?php if (has_nav_menu('consulting_solution_menu')): ?>
							<div class="mobile-nav__container">
								<div class="mobile-nav__info"><?php echo $consulting_solution; ?></div>
								<?php
									wp_nav_menu(array(
										'theme_location' => 'consulting_solution_menu',
										'menu_class' => 'mobile-nav__submenu mobile-nav__submenu--small',
										'container' => false,
										'link_class'   => 'mobile-nav__subitem mobile-nav__subitem--small',
										'link_before' => '<span class="content content--small">',
										'link_after' => '</span>'
									));
								?>
							</div>
						<?php endif; ?>
						<span class="mobile-nav__header t-caption">By industry</span>
						<?php if (has_nav_menu('consulting_industry_menu')): ?>
							<div class="mobile-nav__container">
								<div class="mobile-nav__info"><?php echo $consulting_industry; ?></div>
								<?php
									wp_nav_menu(array(
										'theme_location' => 'consulting_industry_menu',
										'menu_class' => 'mobile-nav__submenu mobile-nav__submenu--small',
										'container' => false,
										'link_class'   => 'mobile-nav__subitem mobile-nav__subitem--small',
										'link_before' => '<span class="content content--small">',
										'link_after' => '</span>'
									));
								?>
							</div>
						<?php endif; ?>
					</div>
				</li>
				<!-- MENU ITEM -->
				<li class="mobile-nav__item">
					<div class="mobile-nav__parent">
						<a href="<?php echo $menu_link['url']; ?>">
							<span class="text"><?php echo $menu_link['title']; ?></span>
						</a>
					</div>
				</li>
				<!-- FOURTH DROPDOWN -->
				<li class="mobile-nav__item">
					<div class="mobile-nav__parent">
						<button class="text"><?php echo $fourth_dropdown; ?></button>
						<svg class="svg-nav-arrow-down">
							<use xlink:href="#svg-nav-arrow-down"></use>
						</svg>
					</div>
					<div class="mobile-nav__sub">
						<span class="mobile-nav__header t-caption">Learn</span>
						<?php if (has_nav_menu('resources_learn_menu')): ?>
							<div class="mobile-nav__container">
								<?php
									wp_nav_menu(array(
										'theme_location' => 'resources_learn_menu',
										'menu_class' => 'mobile-nav__submenu',
										'container' => true,
										'link_class'   => 'mobile-nav__subitem',
										'link_before' => '<span class="content">',
										'link_after' => '</span>'
									));
								?>
							</div>
						<?php endif; ?>
						<span class="mobile-nav__header t-caption">Engage</span>
						<?php if (has_nav_menu('resources_engage_menu')): ?>
							<div class="mobile-nav__container">
								<?php
									wp_nav_menu(array(
										'theme_location' => 'resources_engage_menu',
										'menu_class' => 'mobile-nav__submenu',
										'container' => true,
										'link_class'   => 'mobile-nav__subitem',
										'link_before' => '<span class="content">',
										'link_after' => '</span>'
									));
								?>
							</div>
						<?php endif; ?>
					</div>
				</li>
			</ul>
			<div class="mobile-nav__second">
				<?php if (has_nav_menu('header_menu')): ?>
					<?php
						wp_nav_menu(array(
							'theme_location' => 'header_menu',
							'menu_class' => 'mobile-nav__second-nav',
							'container' => false,
							'link_class'   => 'item',
							'link_before' => '<span class="content">',
							'link_after' => '</span>',
						));
					?>
				<?php endif; ?>
			</div>
		</div>
		<div class="mobile-nav__footer">
			<?php if (is_array($header_button) && !empty($header_button['text1'])): ?>
				<div class="footer__item t-paragraph">
					<p class="footer__content t-interface--4"><?php echo esc_html($header_button['text1']); ?></p>
					<?php if (!empty($header_button['link1']) && is_array($header_button['link1'])): ?>
						<div class="footer__btn-hld u-btn-hld">
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
						<div class="footer__btn-hld u-btn-hld">
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
