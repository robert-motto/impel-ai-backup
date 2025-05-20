<?php
	$logo      = get_field('logo_white', 'options');
	$buttons   = get_field('footer_buttons', 'options')['buttons_group'];
	$copyright = get_field('copyright', 'options');
	$address   = get_field('address', 'options');
?>
<footer class="site-footer is-dark">
	<div class="l-wrapper">
		<div class="site-footer__top">
			<div class="site-footer__logo-hld">
				<a class="site-footer__logo" href="<?php echo get_home_url(); ?>" title="<?php _e('Go to home', get_option('template')); ?>">
					<?php
						if($logo) {
							echo file_get_contents($logo);
						}
						else{
							get_icon('logo');
						}
					?>
				</a>
				<?php get_acf_component('buttons', [
					'data' => $buttons,
					'classes' => 'site-footer__buttons',
				]); ?>
			</div>
			<div class="site-footer__menus-hld">
				<?php
					get_component('footer-menu', [
						'menu_name' => 'footer_menu_col_1',
						'classes'   => 'site-footer__menu--1',
					]);
					get_component('footer-menu', [
						'menu_name' => 'footer_menu_col_2',
						'classes'   => 'site-footer__menu--2',
					]);
					get_component('footer-menu', [
						'menu_name' => 'footer_menu_col_3',
						'classes'   => 'site-footer__menu--3',
					]);
					get_component('footer-menu', [
						'menu_name' => 'footer_menu_col_4',
						'classes'   => 'site-footer__menu--4',
					]);
				?>
			</div>
		</div>
		<div class="site-footer__footer">
			<span class="">Copyright &copy; <?php echo date('Y'); ?>. <?php echo $copyright;?></span>
			<?php
				get_component('socials', [
					'socials_additional_class' => 'site-footer'
				])
			?>
		</div>
	</div>
</footer>




