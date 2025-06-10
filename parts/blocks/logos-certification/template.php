<?php /*
	Block Name: Logos Certification
	Block Align: center
	Block Icon: awards
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group            = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$color_mode      		= $group['section_settings_group']['mode'] ?? 'light';
		$color_mode_variant	= $group['mode_variant'] ?? 'regular';
		$heading         		= $group['heading_box_group'] ?? '';
		$layout_variant   = $group['layout_variant'] ?? 'compact';
		$display_mode     = $group['display_mode'] ?? 'grid';
		$logos            = $group['logos'] ?? [];
		$carousel_settings = $group['carousel_settings'] ?? [];

		$autoplay_speed  = $carousel_settings['autoplay_speed'] ?? 3000;
		$pause_on_hover  = $carousel_settings['pause_on_hover'] ?? true;
		$slides_per_view = $carousel_settings['slides_per_view'] ?? 5;

		$buttons = $group['action_group_group'] ?? [];

		$fallback_image_path = get_template_directory() . '/screenshot.jpg';
		$fallback_image_uri = get_template_directory_uri() . '/screenshot.jpg';

		// Section classes
		$classes = ['js-section', 'l-section', 'l-section--logos-certification', 'js-logos-certification', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}", "is-{$layout_variant}"];

		$unique_id = 'logos-certification-' . uniqid();
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="logos-certification">
		<div class="logos-certification">
			<div class="l-wrapper">
				<?php
					get_acf_component(
						'heading-box', [
							'data' => $heading,
						],
					);
				?>
			</div>

			<?php if (!empty($logos)) : ?>
				<?php if ($display_mode === 'carousel') : ?>
					<?php
						// Triple the logos array for seamless loop functionality
						$tripled_logos = array_merge($logos, $logos, $logos);
					?>
					<div class="logos-certification__carousel-container">
						<div class="logos-certification__carousel js-logos-carousel swiper" id="<?php echo esc_attr($unique_id); ?>"
							data-autoplay="<?php echo esc_attr($autoplay_speed); ?>"
							data-pause-hover="<?php echo esc_attr($pause_on_hover ? 'true' : 'false'); ?>"
							data-slides-per-view="<?php echo esc_attr($slides_per_view); ?>">
							<div class="swiper-wrapper">
								<?php foreach ($tripled_logos as $item) : ?>
									<?php
										$logo = $item['logo'] ?? [];
										$title = $item['title'] ?? '';
										$description = $item['description'] ?? '';
										$link = $item['link'] ?? '';

										if (empty($logo) || !isset($logo['id'])) {
											if (file_exists($fallback_image_path)) {
												$fallback_attachment = attachment_url_to_postid($fallback_image_uri);
												if ($fallback_attachment) {
													$logo = ['id' => $fallback_attachment];
												} else {
													$logo = [
														'url' => $fallback_image_uri,
														'alt' => $title ?: 'Logo'
													];
												}
											}
										}

										$alt_text = !empty($logo['alt']) ? $logo['alt'] : $title;
										$alt_text = !empty($alt_text) ? $alt_text : 'Partner Logo';
									?>
									<div class="logos-certification__item swiper-slide">
										<?php if (!empty($link)) : ?>
											<a href="<?php echo esc_url($link); ?>" class="logos-certification__link" target="_blank" rel="noopener">
										<?php endif; ?>

										<?php if ($layout_variant === 'compact') : ?>
											<div class="logos-certification__logo-wrapper">
												<?php if (!empty($logo['id'])) : ?>
													<?php echo bis_get_attachment_picture(
														$logo['id'],
														[
															560  => [ 180, 100, 1 ],
															1024 => [ 180, 100, 1 ],
															1920 => [ 180, 100, 1 ],
															2800 => [ 360, 200, 1 ],
														],
														[
															'alt'     => esc_attr($alt_text),
															'class'   => 'logos-certification__logo',
															'loading' => 'lazy',
														],
													); ?>
												<?php elseif (!empty($logo['url'])) : ?>
													<img class="logos-certification__logo" src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($alt_text); ?>"  />
												<?php endif; ?>
											</div>
										<?php else : ?>
											<div class="logos-certification__extended-item">
												<div class="logos-certification__logo-wrapper">
													<?php if (!empty($logo['id'])) : ?>
														<?php echo bis_get_attachment_picture(
															$logo['id'],
															[
																560  => [ 180, 100, 1 ],
																1024 => [ 180, 100, 1 ],
																1920 => [ 180, 100, 1 ],
																2800 => [ 360, 200, 1 ],
															],
															[
																'alt'     => esc_attr($alt_text),
																'class'   => 'logos-certification__logo',
																'loading' => 'lazy',
															],
														); ?>
													<?php elseif (!empty($logo['url'])) : ?>
														<img class="logos-certification__logo" src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($alt_text); ?>"  />
													<?php endif; ?>
												</div>
												<?php if (!empty($title)) : ?>
													<div class="logos-certification__title"><?php echo esc_html($title); ?></div>
												<?php endif; ?>
												<?php if (!empty($description)) : ?>
													<div class="logos-certification__description"><?php echo esc_html($description); ?></div>
												<?php endif; ?>
											</div>
										<?php endif; ?>

										<?php if (!empty($link)) : ?>
											</a>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				<?php else: ?>
					<div class="l-wrapper">
						<div class="logos-certification__grid-container js-logos-grid-container">
							<?php foreach ($logos as $item) :
								$logo = $item['logo'] ?? [];
								$alt_text = !empty($logo['alt']) ? $logo['alt'] : 'Logo';
							?>
								<?php echo bis_get_attachment_picture(
										$logo['id'],
									[
										560  => [ 180, 100, 1 ],
										1024 => [ 180, 100, 1 ],
										1920 => [ 180, 100, 1 ],
										2800 => [ 360, 200, 1 ],
									],
									[
										'alt'     => esc_attr($alt_text),
										'class'   => 'logos-certification__logo'
									],
								); ?>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<div class="l-wrapper">
				<?php
					get_acf_component(
						'action-group', [
							'data' => $buttons,
							'classes' => 'logos-certification__btns',
						],
					);
				?>
			</div>
		</div>
	</section>
<?php endif; ?>
