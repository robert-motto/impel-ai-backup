<?php /*
	Block Name: Vertical Scrolling Cards
	Block Align: center
	Block Icon: format-gallery
*/ ?>
<?php if (isset($block['data']['is_preview'])) : ?>
	<?php block_preview(__FILE__); ?>
<?php else : ?>
	<?php
	$group						= isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
	$caption					= $group['caption'] ?? '';
	$heading					= $group['heading'] ?? '';
	$content					= $group['content'] ?? '';
	$buttons					= $group['buttons_group'] ?? [];
	$cards_media_type = $group['cards_media_type'] ?? 'image';
	$cards						= $group['cards'] ?? [];
	$has_background		= $group['has_background'] ?? false;
	$background_color = $group['background_color'] ?? 'light';

	$fallback_image_path = get_template_directory() . '/screenshot.jpg';
	$fallback_image_uri	= get_template_directory_uri() . '/screenshot.jpg';

	$classes = ['js-section', 'l-section', 'l-section--sticky-content-scroll', 'l-section--vertical-scrolling-cards'];
	if ($has_background) {
		$classes[] = 'is-' . $background_color;
	}

	$unique_id = 'sticky-content-scroll-' . uniqid();
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="sticky-content-scroll" data-media-type="<?php echo esc_attr($cards_media_type); ?>">
		<div class="sticky-content-scroll l-wrapper l-wrapper--medium">
			<div class="sticky-content-scroll__content">
				<div class="sticky-content-scroll__sticky-wrapper">
					<?php if (!empty($caption)) : ?>
						<div class="sticky-content-scroll__caption">
							<?php echo esc_html($caption); ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($heading)) : ?>
						<div class="sticky-content-scroll__heading">
							<?php echo $heading; ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($content)) : ?>
						<div class="sticky-content-scroll__body">
							<?php echo $content; ?>
						</div>
					<?php endif; ?>
					<?php
					get_acf_components([
						'buttons' => [
							'data'		=> $buttons,
							'classes' => 'sticky-content-scroll__btns',
						],
					]);
					?>
				</div>
			</div>

			<?php if (!empty($cards)) : ?>
				<div class="sticky-content-scroll__cards" id="<?php echo esc_attr($unique_id); ?>">
					<?php foreach ($cards as $card) : ?>
						<?php
						$badge_label = $card['badge_label'] ?? '';
						$headline		= $card['headline'] ?? '';
						$body				= $card['body'] ?? '';
						$card_link	 = $card['card_link'] ?? [];

						// Handle media based on cards_media_type
						$media = null;
						if ($cards_media_type === 'image') {
							$media = $card['image'] ?? '';
						} else {
							$media = $card['icon'] ?? '';
						}

						// Set fallback image if none is selected and media type is image
						if ($cards_media_type === 'image' && (empty($media) || !isset($media['id']))) {
							if (file_exists($fallback_image_path)) {
								$fallback_attachment = attachment_url_to_postid($fallback_image_uri);
								if ($fallback_attachment) {
									$media = ['id' => $fallback_attachment];
								} else {
									$media = [
										'url' => $fallback_image_uri,
										'alt' => wp_strip_all_tags($headline ?? 'Card item')
									];
								}
							}
						}
						?>
						<div class="sticky-content-scroll__card">
							<?php if ($cards_media_type === 'image' && !empty($media)) : ?>
								<div class="sticky-content-scroll__card-media">
									<?php
									if (!empty($media['id'])) {
										// Use WordPress default image function as fallback
										echo wp_get_attachment_image(
											$media['id'],
											'large',
											false,
											[
												'alt'		 => !empty($media['alt']) ? $media['alt'] : wp_strip_all_tags($headline ?? 'Card image'),
												'class' => 'sticky-content-scroll__card-img',
												'loading' => 'lazy',
											]
										);
									} elseif (!empty($media['url'])) {
										echo '<img class="sticky-content-scroll__card-img" src="' . esc_url($media['url']) . '" alt="' . esc_attr($media['alt'] ?? 'Card image') . '"  />';
									}
									?>
								</div>
							<?php elseif ($cards_media_type === 'icon' && !empty($media)) : ?>
								<div class="sticky-content-scroll__card-icon-container">
									<?php
									if (!empty($media['id'])) {
										echo wp_get_attachment_image(
											$media['id'],
											'full',
											false,
											[
												'class' => 'sticky-content-scroll__card-icon',
												'loading' => 'lazy',
											]
										);
									} elseif (!empty($media['url'])) {
										echo '<img class="sticky-content-scroll__card-icon" src="' . esc_url($media['url']) . '" alt="' . esc_attr($media['alt'] ?? 'Icon') . '"  />';
									}
									?>
								</div>
							<?php endif; ?>

							<div class="sticky-content-scroll__card-content">
								<?php if (!empty($badge_label)) : ?>
									<div class="sticky-content-scroll__card-badge">
										<?php echo esc_html($badge_label); ?>
									</div>
								<?php endif; ?>

								<?php if (!empty($headline)) : ?>
									<h3 class="sticky-content-scroll__card-heading">
										<?php echo $headline; ?>
									</h3>
								<?php endif; ?>

								<?php if (!empty($body)) : ?>
									<div class="sticky-content-scroll__card-body">
										<?php echo $body; ?>
									</div>
								<?php endif; ?>

								<?php if (!empty($card_link) && !empty($card_link['url'])) : ?>
									<div class="sticky-content-scroll__card-link">
										<a href="<?php echo esc_url($card_link['url']); ?>" class="sticky-content-scroll__card-btn" <?php echo !empty($card_link['target']) ? 'target="' . esc_attr($card_link['target']) . '" rel="noopener"' : ''; ?>>
											<?php echo esc_html($card_link['title'] ?: 'Learn More'); ?>
											<span class="sticky-content-scroll__card-btn-arrow">→</span>
										</a>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
