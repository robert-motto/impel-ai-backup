<?php /*
	Block Name: Post CTA 2
	Block Align: center
	Block Icon: megaphone
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group        = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);

		$mode           = $group['mode'] ?? 'is-dark';
		$heading        = $group['heading_group'] ?? [];
		$title          = $heading['title'] ?? '';
		$content        = $group['content_group'] ?? [];
		$buttons        = $group['buttons_group'] ?? [];
		$layout_classes = $group['image_position'] ?? '';
		$image          = $group['image'] ?? '';
	?>
	<div class="block-post-cta-2 l-row <?php echo $layout_classes; ?> <?php echo $mode; ?> block-mb-large">
		<div class="block-post-cta-2__content-hld">
			<?php
				get_acf_components([
					'heading' => [
						'data'    => $heading,
						'classes' => 'block-post-cta-2__heading',
					],
					'content' => [
						'data'    => $content,
						'classes' => 'block-post-cta-2__content',
					],
					'buttons' => [
						'data'    => $buttons,
						'classes' => 'block-post-cta-2__btns',
					],
				]);
			?>
		</div>
		<?php
			if(!empty($image)) {
				echo bis_get_attachment_picture(
					$image['id'],
					[
						1024 => [ 600, 300, 0 ],
						1024 => [ 600 * 2, 300 * 2, 0 ],
						1920 => [ 600, 1000, 0 ],
						2800 => [ 600 * 2, 1000 * 2, 0 ],
					],
					[
						'alt'     => $image['alt'] ? $image['alt'] : wp_strip_all_tags($title),
						'class'   => 'block-post-cta-2__img',
						'loading' => 'lazy',
					],
				);
			}
		?>
	</div>
<?php endif; ?>
