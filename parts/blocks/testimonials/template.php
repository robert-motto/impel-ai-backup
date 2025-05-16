<?php /*
	Block Name: Testimonials
	Block Align: center
	Block Icon: testimonial
*/ ?>
<?php if (isset($block['data']['is_preview'])) : ?>
	<?php block_preview(__FILE__); ?>
<?php else : ?>
	<?php
	$group 							= isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
	$heading						= $group['heading_box_group'] ?? '';
	$testimonials 			= $group['testimonials'] ?? [];
	$color_mode      		= $group['section_settings_group']['mode'] ?? 'light';
	$color_mode_variant	= $group['mode_variant'] ?? 'regular';
	$button 						= $group['button_group'] ?? [];

	$show_progressbar = true;

	// Ensure we have at least 1 testimonial
	if (empty($testimonials)) {
		$testimonials = [
			[
				'category_label' => 'OEMs',
				'quote' => '"In just three months the AI has influenced $3.2MM in revenue"',
				'person_name' => 'Jess McQuillan',
				'company' => 'Central Maine Motors',
				'media_type' => 'video',
				'has_metric' => true,
				'metric_value' => '75%',
				'metric_description' => 'Boosts conversion rates through personalized interactions.',
			]
		];
	}

	// Section classes
	$classes = ['l-section', 'l-section--testimonials', 'js-testimonials', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}"];
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-block="testimonials">
		<div class="testimonials l-wrapper">
			<?php
			get_acf_component(
				'heading-box',
				[
					'data' => $heading,
				],
			);
			?>

			<?php if (!empty($testimonials)) : ?>
				<div class="testimonials__carousel-container">
					<div class="testimonials__carousel js-testimonials-carousel swiper" id="<?php echo esc_attr($unique_id); ?>"
						data-autoplay="<?php echo esc_attr($autoplay_speed); ?>"
						data-pause-hover="<?php echo esc_attr($pause_on_hover ? 'true' : 'false'); ?>"
						data-slides-per-view="<?php echo esc_attr($slides_per_view); ?>"
						data-show-scrollbar="<?php echo esc_attr($show_scrollbar ? 'true' : 'false'); ?>"
						data-show-progressbar="<?php echo esc_attr($show_progressbar ? 'true' : 'false'); ?>">
						<div class="swiper-wrapper">

							<?php foreach ($testimonials as $index => $testimonial) : ?>
								<?php
								$category_label = $testimonial['category_label'] ?? '';
								$quote = $testimonial['quote'] ?? '';
								$person_name = $testimonial['person_name'] ?? '';
								$company = $testimonial['company'] ?? '';
								$media_type = $testimonial['media_type'] ?? 'image';
								$thumbnail = $testimonial['thumbnail'] ?? '';
								$video = $testimonial['video_group'] ?? [];
								$has_metric = $testimonial['has_metric'] ?? false;
								$metrics = $testimonial['metrics'] ?? [];

								// Set fallback image if none is selected
								if (empty($thumbnail) || !isset($thumbnail['id'])) {
									$fallback_image_path = get_template_directory() . '/screenshot.jpg';
									$fallback_image_uri = get_template_directory_uri() . '/screenshot.jpg';
									if (file_exists($fallback_image_path)) {
										$fallback_attachment = attachment_url_to_postid($fallback_image_uri);
										if ($fallback_attachment) {
											$thumbnail = ['id' => $fallback_attachment];
										} else {
											$thumbnail = [
												'url' => $fallback_image_uri,
												'alt' => wp_strip_all_tags($person_name ?? 'Testimonial')
											];
										}
									}
								}
								?>
								<div class="testimonials__item swiper-slide" data-index="<?php echo esc_attr($index); ?>">
									<div class="testimonials__media-container">
										<?php if ($media_type === 'image' && !empty($thumbnail)) : ?>
											<?php if (!empty($thumbnail['id'])) : ?>
												<?php if (function_exists('bis_get_attachment_picture')) : ?>
													<?php
													echo bis_get_attachment_picture(
														$thumbnail['id'],
														[
															560  => [560, 315, 1],
															1024 => [800, 450, 1],
															1920 => [800, 450, 1],
															2800 => [800 * 2, 450 * 2, 1],
														],
														[
															'alt'     => $thumbnail['alt'] ? $thumbnail['alt'] : wp_strip_all_tags($person_name ?? 'Testimonial'),
															'class'   => 'testimonials__img',
															'loading' => 'lazy',
														],
													);
													?>
												<?php else : ?>
													<?php
													echo wp_get_attachment_image(
														$thumbnail['id'],
														'large',
														false,
														[
															'alt'     => $thumbnail['alt'] ? $thumbnail['alt'] : wp_strip_all_tags($person_name ?? 'Testimonial'),
															'class'   => 'testimonials__img',
															'loading' => 'lazy',
														]
													);
													?>
												<?php endif; ?>
											<?php elseif (!empty($thumbnail['url'])) : ?>
												<img class="testimonials__img" src="<?php echo esc_url($thumbnail['url']); ?>" alt="<?php echo esc_attr($thumbnail['alt'] ?? wp_strip_all_tags($person_name ?? 'Testimonial')); ?>" loading="lazy" />
											<?php endif; ?>
										<?php endif; ?>

										<?php if ($media_type === 'video' && !empty($video)) : ?>
											<?php get_acf_component('video', [
												'data'    => $video,
												'classes' => $padding_bottom,
											]); ?>
										<?php endif; ?>

										<?php if ($has_metric && !empty($metrics)) : ?>
											<div class="testimonials__metrics">
												<?php
												foreach ($metrics as $metric) :
													if (!empty($metric['metric_value']) && !empty($metric['metric_description'])) : ?>
														<div class="testimonials__metric">
															<div class="testimonials__metric-value">
																<span><?php echo esc_html($metric['metric_value']); ?></span>
																<div class="testimonials__metric-icon">
																	<?php get_icon($metric['metric_icon'] === 'arrow-up' ? 'arrow-up-right' : 'arrow-down-right'); ?>
																</div>
															</div>
															<div class="testimonials__metric-description">
																<?php echo esc_html($metric['metric_description']); ?>
															</div>
														</div>
												<?php endif;
												endforeach;
												?>
											</div>
										<?php endif; ?>
									</div>

									<div class="testimonials__content">
										<?php if (!empty($category_label)) : ?>
											<div class="testimonials__category">
												<?php echo esc_html($category_label); ?>
											</div>
										<?php endif; ?>

										<?php if (!empty($quote)) : ?>
											<div class="testimonials__quote">
												<?php echo $quote; ?>
											</div>
										<?php endif; ?>

										<div class="testimonials__author">
											<?php if (!empty($person_name)) : ?>
												<div class="testimonials__person">
													<?php echo esc_html($person_name); ?>
												</div>
											<?php endif; ?>
											<?php if (!empty($company)) : ?>
												<div class="testimonials__company">
													<?php echo esc_html($company); ?>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="testimonials__navigation">
						<div class="testimonials__buttons">
							<button class="testimonials__button-prev js-testimonials-prev" aria-label="<?php echo esc_attr__('Previous', 'impel-ai'); ?>"><?php get_icon('swiper-arrow-right'); ?></button>
							<div class="testimonials__buttons-divider"></div>
							<button class="testimonials__button-next js-testimonials-next" aria-label="<?php echo esc_attr__('Next', 'impel-ai'); ?>"><?php get_icon('swiper-arrow-right'); ?></button>
						</div>
						<div class="testimonials__progressbar js-testimonials-progressbar"></div>
						<?php if ($button['button']):
							get_acf_component('button', [
								'data' => $button,
							]);
						endif; ?>
					</div>

				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>