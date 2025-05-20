<?php /*
	Block Name: Carousel Slider
	Block Align: center
	Block Icon: slides
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group            = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$caption          = $group['caption'] ?? '';
		$heading          = $group['heading'] ?? '';
		$content          = $group['content'] ?? '';
		$buttons          = $group['buttons_group'] ?? [];
		$cards            = $group['cards'] ?? [];
		$carousel_settings = $group['carousel_settings'] ?? [];
		$has_background   = $group['has_background'] ?? false;
		$background_color = $group['background_color'] ?? 'light';

		$autoplay_speed  = $carousel_settings['autoplay_speed'] ?? 3000;
		$pause_on_hover  = $carousel_settings['pause_on_hover'] ?? true;
		$slides_per_view = $carousel_settings['slides_per_view'] ?? 3;
		$show_scrollbar  = $carousel_settings['show_scrollbar'] ?? true;

		$fallback_image_path = get_template_directory() . '/screenshot.jpg';
		$fallback_image_uri = get_template_directory_uri() . '/screenshot.jpg';

		$classes = ['l-section', 'l-section--carousel-slider', 'js-carousel-slider'];
		if ($has_background) {
			$classes[] = 'is-' . $background_color;
		}

		$unique_id = 'carousel-slider-' . uniqid();

		// Determine if we should enable autoplay
		$enable_autoplay = ($autoplay_speed > 0);
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="carousel-slider">
		<div class="carousel-slider l-wrapper js-carousel-slider">
			<?php if (!empty($caption) || !empty($heading) || !empty($content)) : ?>
				<div class="carousel-slider__header">
					<?php if (!empty($caption)) : ?>
						<div class="carousel-slider__caption">
							<?php echo esc_html($caption); ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($heading)) : ?>
						<div class="carousel-slider__heading">
							<?php echo $heading; ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($content)) : ?>
						<div class="carousel-slider__body">
							<?php echo $content; ?>
						</div>
					<?php endif; ?>
					<?php
						get_acf_components([
							'buttons' => [
								'data'    => $buttons,
								'classes' => 'carousel-slider__btns',
							],
						]);
					?>
				</div>
			<?php endif; ?>

			<?php if (!empty($cards)) : ?>
				<div class="carousel-slider__carousel-container">
					<div class="carousel-slider__carousel js-carousel-slider-swiper swiper" id="<?php echo esc_attr($unique_id); ?>"
						data-autoplay="<?php echo esc_attr($autoplay_speed); ?>"
						data-pause-hover="<?php echo esc_attr($pause_on_hover ? 'true' : 'false'); ?>"
						data-slides-per-view="<?php echo esc_attr($slides_per_view); ?>"
						data-show-scrollbar="<?php echo esc_attr($show_scrollbar ? 'true' : 'false'); ?>">
						<div class="swiper-wrapper">
							<?php foreach ($cards as $card) : ?>
								<?php
									$badge_label = $card['badge_label'] ?? '';
									$headline = $card['headline'] ?? '';
									$body = $card['body'] ?? '';
									$card_buttons = $card['card_buttons_group'] ?? [];
									$media_type = $card['media_type'] ?? 'none';
									$image = $card['image'] ?? '';
									$svg_icon = $card['svg_icon'] ?? '';

									// Set fallback image if none is selected and media type is image
									if ($media_type === 'image' && (empty($image) || !isset($image['id']))) {
										$fallback_image_path = get_template_directory() . '/screenshot.jpg';
										$fallback_image_uri = get_template_directory_uri() . '/screenshot.jpg';
										if (file_exists($fallback_image_path)) {
											$fallback_attachment = attachment_url_to_postid($fallback_image_uri);
											if ($fallback_attachment) {
												$image = ['id' => $fallback_attachment];
											} else {
												$image = [
													'url' => $fallback_image_uri,
													'alt' => wp_strip_all_tags($headline ?? 'Carousel item')
												];
											}
										}
									}
								?>
								<div class="carousel-slider__item swiper-slide">
									<div class="carousel-slider__card">
										<div class="carousel-slider__media-container <?php echo $media_type === 'svg' ? 'carousel-slider__media-container--icon' : ''; ?>">
											<?php if ($media_type === 'image' && !empty($image)) : ?>
												<?php
													if (!empty($image['id'])) {
														echo bis_get_attachment_picture(
															$image['id'],
															[
																560  => [ 560, 373, 1 ],
																1024 => [ 720, 480, 1 ],
																1920 => [ 720, 480, 1 ],
																2800 => [ 720 * 2, 480 * 2, 1 ],
															],
															[
																'alt'     => $image['alt'] ? $image['alt'] : wp_strip_all_tags($headline ?? 'Carousel item'),
																'class'   => 'carousel-slider__img',
																'loading' => 'lazy',
															],
														);
													} elseif (!empty($image['url'])) {
														echo '<img class="carousel-slider__img" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt'] ?? 'Carousel item') . '" loading="lazy" />';
													}
												?>
											<?php elseif ($media_type === 'svg' && !empty($svg_icon)) : ?>
												<?php
													if (!empty($svg_icon['id'])) {
														echo wp_get_attachment_image(
															$svg_icon['id'],
															'full',
															false,
															[
																'class' => 'carousel-slider__svg',
																'loading' => 'lazy',
															]
														);
													} elseif (!empty($svg_icon['url'])) {
														echo '<img class="carousel-slider__svg" src="' . esc_url($svg_icon['url']) . '" alt="' . esc_attr($svg_icon['alt'] ?? 'SVG icon') . '" loading="lazy" />';
													}
												?>
											<?php endif; ?>
										</div>

										<div class="carousel-slider__content">
											<?php if (!empty($badge_label)) : ?>
												<div class="carousel-slider__badge">
													<?php echo esc_html($badge_label); ?>
												</div>
											<?php endif; ?>

											<?php if (!empty($headline)) : ?>
												<h3 class="carousel-slider__item-heading">
													<?php echo $headline; ?>
												</h3>
											<?php endif; ?>

											<?php if (!empty($body)) : ?>
												<div class="carousel-slider__item-content">
													<?php echo $body; ?>
												</div>
											<?php endif; ?>

											<?php if (!empty($card_buttons)) : ?>
												<?php
													get_acf_components([
														'buttons' => [
															'data'    => $card_buttons,
															'classes' => 'carousel-slider__item-btns',
														],
													]);
												?>
											<?php endif; ?>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>

						<?php if (count($cards) > $slides_per_view) : ?>
							<div class="carousel-slider__navigation">
								<div class="carousel-slider__button-prev js-carousel-slider-prev"></div>
								<div class="carousel-slider__button-next js-carousel-slider-next"></div>
							</div>

							<?php if ($show_scrollbar) : ?>
								<div class="carousel-slider__scrollbar js-carousel-slider-scrollbar"></div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
