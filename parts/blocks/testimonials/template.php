<?php /*
	Block Name: Testimonials
	Block Align: center
	Block Icon: testimonial
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$caption = $group['caption'] ?? '';
		$heading = $group['heading'] ?? '';
		$content = $group['content'] ?? '';
		$testimonials = $group['testimonials'] ?? [];
		$buttons = $group['buttons_group'] ?? [];
		$has_background = $group['has_background'] ?? false;
		$background_color = $group['background_color'] ?? 'light';

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
		$classes = ['l-section', 'l-section--testimonials', 'js-testimonials'];
		if ($has_background) {
			$classes[] = 'is-' . $background_color;
		}
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="testimonials">
		<div class="testimonials l-wrapper">
			<?php if (!empty($caption) || !empty($heading) || !empty($content)) : ?>
				<div class="testimonials__header">
					<?php if (!empty($caption)) : ?>
						<div class="testimonials__caption">
							<?php echo esc_html($caption); ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($heading)) : ?>
						<div class="testimonials__heading">
							<?php echo $heading; ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($content)) : ?>
						<div class="testimonials__body">
							<?php echo $content; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if (!empty($testimonials)) : ?>
				<div class="testimonials__grid">
					<?php foreach ($testimonials as $index => $testimonial) : ?>
						<?php
							$category_label = $testimonial['category_label'] ?? '';
							$quote = $testimonial['quote'] ?? '';
							$person_name = $testimonial['person_name'] ?? '';
							$company = $testimonial['company'] ?? '';
							$media_type = $testimonial['media_type'] ?? 'video';
							$thumbnail = $testimonial['thumbnail'] ?? '';
							$video_url = $testimonial['video_url'] ?? '';
							$has_metric = $testimonial['has_metric'] ?? false;
							$metric_value = $testimonial['metric_value'] ?? '';
							$metric_description = $testimonial['metric_description'] ?? '';

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
						<div class="testimonials__item" data-index="<?php echo esc_attr($index); ?>">
							<div class="testimonials__media-container">
								<?php if (!empty($thumbnail)) : ?>
									<?php if (!empty($thumbnail['id'])) : ?>
										<?php
											echo bis_get_attachment_picture(
												$thumbnail['id'],
												[
													560  => [ 560, 315, 1 ],
													1024 => [ 800, 450, 1 ],
													1920 => [ 800, 450, 1 ],
													2800 => [ 800 * 2, 450 * 2, 1 ],
												],
												[
													'alt'     => $thumbnail['alt'] ? $thumbnail['alt'] : wp_strip_all_tags($person_name ?? 'Testimonial'),
													'class'   => 'testimonials__img',
													'loading' => 'lazy',
												],
											);
										?>
									<?php elseif (!empty($thumbnail['url'])) : ?>
										<img class="testimonials__img" src="<?php echo esc_url($thumbnail['url']); ?>" alt="<?php echo esc_attr($thumbnail['alt'] ?? wp_strip_all_tags($person_name ?? 'Testimonial')); ?>" loading="lazy" />
									<?php endif; ?>
								<?php endif; ?>

								<?php if ($media_type === 'video' && !empty($video_url)) : ?>
									<button class="testimonials__play-btn js-video-trigger" data-video-url="<?php echo esc_url($video_url); ?>">
										<img class="testimonials__play-icon" src="<?php echo esc_url(get_template_directory_uri() . '/parts/blocks/testimonials/play-icon.svg'); ?>" alt="<?php echo esc_attr__('Play video', 'impel-ai'); ?>" width="24" height="24" />
									</button>
								<?php endif; ?>

								<?php if ($has_metric && (!empty($metric_value) || !empty($metric_description))) : ?>
									<div class="testimonials__metric">
										<?php if (!empty($metric_value)) : ?>
											<div class="testimonials__metric-value">
												<?php echo esc_html($metric_value); ?>
											</div>
										<?php endif; ?>
										<?php if (!empty($metric_description)) : ?>
											<div class="testimonials__metric-description">
												<?php echo esc_html($metric_description); ?>
											</div>
										<?php endif; ?>
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
			<?php endif; ?>

			<?php if (!empty($buttons)) : ?>
				<?php
					get_acf_components([
						'buttons' => [
							'data'    => $buttons,
							'classes' => 'testimonials__btns',
						],
					]);
				?>
			<?php endif; ?>
		</div>

		<!-- Video Modal -->
		<div class="testimonials__modal js-video-modal">
			<div class="testimonials__modal-overlay js-video-modal-close"></div>
			<div class="testimonials__modal-content">
				<button class="testimonials__modal-close js-video-modal-close" aria-label="<?php echo esc_attr__('Close video', 'impel-ai'); ?>">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="testimonials__video-container">
					<div class="testimonials__video-wrapper js-video-wrapper"></div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
