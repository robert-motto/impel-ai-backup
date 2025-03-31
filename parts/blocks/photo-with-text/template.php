<?php /*
	Block Name: Photo with Text
	Block Align: center
	Block Icon: format-aside
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group        = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);

		$layout_classes = $group['image_position'] ?? '';
		$heading        = $group['heading_group'] ?? [];
		$title          = $heading['title'] ?? '';
		$content        = $group['content_group'] ?? [];
		$subheading     = $group['subheading_group'] ?? [];
		$buttons        = $group['buttons_group'] ?? [];
		$image          = $group['image'] ?? '';
	?>
	<section <?php echo section_settings_id($group); ?> class="l-section l-section--pwt <?php echo section_settings_classes($group); ?>" data-block="pwt">
		<div class="pwt l-wrapper l-row <?php echo $layout_classes; ?>">
			<div class="pwt__content-hld">
				<?php
					get_acf_components([
						'heading' => [
							'data'    => $heading,
							'classes' => 'pwt__heading',
						],
						'subheading' => [
							'data'    => $subheading,
							'classes' => 'pwt__subheading',
						],
						'content' => [
							'data'    => $content,
							'classes' => 'pwt__content',
						],
						'buttons' => [
							'data'    => $buttons,
							'classes' => 'pwt__btns',
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
							'class'   => 'pwt__img',
							'loading' => 'lazy',
						],
					);
				}
			?>
		</div>
	</section>
<?php endif; ?>
