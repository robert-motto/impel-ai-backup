<?php get_header(); ?>
<?php
	$p404_title = get_field('404_title', 'options');
	$p404_content = get_field('404_content', 'options');
	$p404_button = get_field('404_button', 'options');
?>
<section class="u-section u-section--p404">
	<div class="p404">
		<div class="u-wrapper">
			<?php if ($p404_title) : ?>
				<h1 class="p404__title"><?php echo $p404_title; ?></h1>
			<?php endif; ?>
			<?php if ($p404_content) : ?>
				<div class="p404__content">
					<?php echo $p404_content; ?>
				</div>
			<?php endif; ?>
			<?php if ($p404_button) : ?>
				<?php
					$button_url = $p404_button['url'];
					$button_title = $p404_button['title'];
					$button_target = $p404_button['target'] ? $p404_button['target'] : '_self';
				?>
				<div class="u-btn-hld p404__btn-hld">
					<a class="u-btn p404__btn" href="<?php echo esc_url($button_url); ?>" target="<?php echo esc_attr($button_target); ?>">
						<span class="text"><?php echo esc_html($button_title); ?></span>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
