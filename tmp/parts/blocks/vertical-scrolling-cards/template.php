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
	$color_mode      		= $group['section_settings_group']['mode'] ?? 'light';
	$color_mode_variant	= $group['mode_variant'] ?? 'regular';

	$fallback_image_path = get_template_directory() . '/screenshot.jpg';
	$fallback_image_uri	= get_template_directory_uri() . '/screenshot.jpg';

	$classes = ['js-section', 'l-section', 'l-section--vertical-scrolling-cards', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}"];

	$unique_id = 'vertical-scrolling-cards-' . uniqid();
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="vertical-scrolling-cards" data-media-type="<?php echo esc_attr($cards_media_type); ?>">
		<div class="vertical-scrolling-cards l-wrapper l-wrapper--medium">
			<div class="vertical-scrolling-cards__content">
				<div class="vertical-scrolling-cards__sticky-wrapper">
					<?php if (!empty($caption)) : ?>
						<div class="vertical-scrolling-cards__caption">
							<?php echo esc_html($caption); ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($heading)) : ?>
						<div class="vertical-scrolling-cards__heading">
							<?php echo $heading; ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($content)) : ?>
						<div class="vertical-scrolling-cards__body">
							<?php echo $content; ?>
						</div>
					<?php endif; ?>
					<?php
					get_acf_components([
						'buttons' => [
							'data'		=> $buttons,
							'classes' => 'vertical-scrolling-cards__btns',
						],
					]);
					?>
				</div>
			</div>

			<?php if (!empty($cards)) : ?>
				<div class="vertical-scrolling-cards__cards" id="<?php echo esc_attr($unique_id); ?>">
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
						<?php if (!empty($card_link) && !empty($card_link['url'])) : ?>
							<a href="<?php echo esc_url($card_link['url']); ?>" class="vertical-scrolling-cards__card">
						<?php else : ?>
							<div class="vertical-scrolling-cards__card">
						<?php endif; ?>
								<?php if ($cards_media_type === 'image' && !empty($media)) : ?>
									<div class="vertical-scrolling-cards__card-media">
										<?php
										if (!empty($media['id'])) {
											// Use WordPress default image function as fallback
											echo wp_get_attachment_image(
												$media['id'],
												'large',
												false,
												[
													'alt'		 => !empty($media['alt']) ? $media['alt'] : wp_strip_all_tags($headline ?? 'Card image'),
													'class' => 'vertical-scrolling-cards__card-img',
													'loading' => 'lazy',
												]
											);
										} elseif (!empty($media['url'])) {
											echo '<img class="vertical-scrolling-cards__card-img" src="' . esc_url($media['url']) . '" alt="' . esc_attr($media['alt'] ?? 'Card image') . '"  />';
										}
										?>
									</div>
								<?php elseif ($cards_media_type === 'icon' && !empty($media)) : ?>
									<div class="vertical-scrolling-cards__card-icon-container">
										<?php
										if (!empty($media['id'])) {
											echo wp_get_attachment_image(
												$media['id'],
												'full',
												false,
												[
													'class' => 'vertical-scrolling-cards__card-icon',
													'loading' => 'lazy',
												]
											);
										} elseif (!empty($media['url'])) {
											echo '<img class="vertical-scrolling-cards__card-icon" src="' . esc_url($media['url']) . '" alt="' . esc_attr($media['alt'] ?? 'Icon') . '"  />';
										}
										?>
									</div>
								<?php endif; ?>

								<div class="vertical-scrolling-cards__card-content">
									<?php if (!empty($badge_label)) : ?>
										<div class="vertical-scrolling-cards__card-badge">
											<?php echo esc_html($badge_label); ?>
										</div>
									<?php endif; ?>

									<?php if (!empty($headline)) : ?>
										<h3 class="vertical-scrolling-cards__card-heading">
											<?php echo $headline; ?>
										</h3>
									<?php endif; ?>

									<?php if (!empty($body)) : ?>
										<div class="vertical-scrolling-cards__card-body">
											<?php echo $body; ?>
										</div>
									<?php endif; ?>
									<div class="vertical-scrolling-cards__card-link">
										<?php
											get_acf_component('button', [
												'data' => [
												'type' => 'link',
												'size' => 'large',
												'button' => [
													'url' => '',
													'title' => 'Read more',
													'target' => '_self'
												],
												'has_icon' => 'y',
												'icon_position' => 'right',
												],
												'classes' => 'card__item-btn',
												'tag' => 'span',
											]);
										?>
									</div>
								</div>
						<?php if (!empty($card_link) && !empty($card_link['url'])) : ?>
							</a>
						<?php else : ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
