<?php
	$logo      = get_field('logo', 'options');
	$buttons   = get_field('footer_buttons', 'options')['buttons_group'];
	$copyright = get_field('copyright', 'options');
	$address   = get_field('address', 'options');
?>
<footer class="site-footer is-dark">
	<!-- Footer Top -->
	<div class="site-footer__top">
		<div class="l-wrapper">
			<div class="site-footer__menus-hld">
				<?php
					get_component('footer-menu', [
						'menu_name' => 'footer_menu_col_1',
						'classes'   => 'site-footer__menu--1',
					]);
				?>
			</div>
		</div>
	</div>
	
	<!-- Footer Bottom -->
	<div class="site-footer__bottom">
		<div class="l-wrapper">
			<div class="site-footer__bottom-content">
				<div class="site-footer__left-group">
					<a class="site-footer__logo" href="<?php echo esc_url(get_home_url()); ?>" title="<?php esc_attr_e('Go to home', get_option('template')); ?>">
						<?php
						if ($logo) {
							$logo_url_parts = wp_parse_url($logo);
							$logo_path = isset($logo_url_parts['path']) ? $logo_url_parts['path'] : '';
							$logo_path_info = pathinfo($logo_path);
							$is_svg = isset($logo_path_info['extension']) && strtolower($logo_path_info['extension']) === 'svg';

							if ($is_svg) {
								$svg_content = false;
								if (strpos($logo, get_home_url()) === 0 && strpos($logo, 'https://') === 0) {
									$context_options = [
										"ssl" => [
											"verify_peer"      => false,
											"verify_peer_name" => false,
										],
									];
									$stream_context = stream_context_create($context_options);
									$svg_content = @file_get_contents($logo, false, $stream_context);
								} else {
									$svg_content = @file_get_contents($logo);
								}

								if ($svg_content) {
									echo $svg_content;
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
					<?php
						get_component('footer-menu', [
							'menu_name' => 'footer_menu_col_2',
							'classes'   => 'site-footer__menu--2',
						]);
					?>
				</div>
				<span class="site-footer__copyright">Copyright &copy; <?php echo date('Y'); ?>. <?php echo $copyright;?></span>
				<?php
					get_component('socials', [
						'socials_additional_class' => 'site-footer'
					])
				?>
			</div>
		</div>
	</div>
</footer>




