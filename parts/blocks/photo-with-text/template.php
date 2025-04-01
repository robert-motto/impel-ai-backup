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
		$heading        = $group['heading'] ?? '';
		$subheading     = $group['subheading'] ?? '';
		$content        = $group['content'] ?? '';
		$buttons        = $group['buttons_group'] ?? [];
		$image          = $group['image'] ?? '';
	?>
	<section <?php echo section_settings_id($group); ?> class="l-section l-section--pwt <?php echo section_settings_classes($group); ?>" data-block="pwt">
		<div class="pwt l-wrapper l-row <?php echo $layout_classes; ?>">
			<div class="pwt__content-hld">
				<?php if (!empty($heading)) : ?>
					<div class="pwt__heading ">
						<?php echo $heading; ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($subheading)) : ?>
					<div class="pwt__subheading">
						<?php echo $subheading; ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($content)) : ?>
					<div class="pwt__content">
						<?php echo $content; ?>
					</div>
				<?php endif; ?>
				<?php
					get_acf_components([
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
							'alt'     => $image['alt'] ? $image['alt'] : wp_strip_all_tags($heading ?? ''),
							'class'   => 'pwt__img',
							'loading' => 'lazy',
						],
					);
				}
			?>
		</div>
	</section>
<?php endif; ?>
