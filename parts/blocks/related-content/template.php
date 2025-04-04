<?php /*
    Block Name: Related Content
    Block Align: center
    Block Icon: editor-ul
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group           = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$caption         = $group['caption'] ?? '';
		$heading         = $group['heading'] ?? '';
		$content         = $group['content'] ?? '';
		$buttons         = $group['buttons_group'] ?? [];
		$related_items   = $group['related_items'] ?? [];

		$classes = ['l-section', 'l-section--related-content', 'js-related-content'];
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="related-content">
		<div class="l-wrapper related-content__wrapper">
			<div class="related-content__intro">
				<?php if (!empty($caption)) : ?>
					<div class="related-content__caption">
						<?php echo esc_html($caption); ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($heading)) : ?>
					<div class="related-content__heading">
						<?php echo $heading; ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($content)) : ?>
					<div class="related-content__body">
						<?php echo $content; ?>
					</div>
				<?php endif; ?>
				<?php
					get_acf_components([
						'buttons' => [
							'data'    => $buttons,
							'classes' => 'related-content__btns',
						],
					]);
				?>
			</div>

			<?php if (!empty($related_items)) : ?>
				<div class="related-content__items">
					<?php foreach ($related_items as $item) : ?>
						<?php
							$item_heading = $item['item_heading'] ?? '';
							$item_description = $item['item_description'] ?? '';
							$item_link_data = $item['item_link'] ?? [];
							$item_url = $item_link_data['url'] ?? '#';
							$item_title = $item_link_data['title'] ?? 'Learn More';
							$item_target = $item_link_data['target'] ?? '_self';
						?>
						<div class="related-content__item">
							<?php if (!empty($item_heading)) : ?>
								<h3 class="related-content__item-heading">
									<?php echo esc_html($item_heading); ?>
								</h3>
							<?php endif; ?>
							<?php if (!empty($item_description)) : ?>
								<div class="related-content__item-description">
									<?php echo wp_kses_post($item_description); ?>
								</div>
							<?php endif; ?>
							<?php if (!empty($item_url) && $item_url !== '#') : ?>
								<a href="<?php echo esc_url($item_url); ?>" class="btn btn--secondary related-content__item-btn" target="<?php echo esc_attr($item_target); ?>">
									<?php echo esc_html($item_title); ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
