<?php /*
	Block Name: Case Study Grid
	Block Align: center
	Block Icon: grid-view
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$caption = $group['caption'] ?? '';
		$heading = $group['heading'] ?? '';
		$content = $group['content'] ?? '';
		$buttons = $group['buttons_group'] ?? [];
		$case_studies = $group['case_studies'] ?? [];
		$show_load_more = $group['show_load_more'] ?? true;
		$load_more_text = $group['load_more_text'] ?? 'Explore more case studies';
		$items_per_load = $group['items_per_load'] ?? 6;
		$has_background = $group['has_background'] ?? false;
		$background_color = $group['background_color'] ?? 'light';

		// Ensure we have at least 1 case study
		if (empty($case_studies)) {
			$case_studies = [
				[
					'title' => 'Medium length section heading goes here',
					'media_type' => 'image',
					'case_study_url' => '#',
					'cta_text' => 'Read Case Study',
					'has_metric' => true,
					'metric_value' => '22%',
					'metric_description' => 'increase in showroom appointment set rate',
				]
			];
		}

		// Section classes
		$classes = ['js-section', 'l-section', 'l-section--case-study-grid', 'js-case-study-grid'];
		if ($has_background) {
			$classes[] = 'is-' . $background_color;
		}

		// How many case studies to show initially (6)
		$initial_display = 6;
		$total_case_studies = count($case_studies);
		$has_hidden_items = $total_case_studies > $initial_display;
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="case-study-grid" data-items-per-load="<?php echo esc_attr($items_per_load); ?>">
		<div class="case-study-grid l-wrapper">
			<?php if (!empty($caption) || !empty($heading) || !empty($content)) : ?>
				<div class="case-study-grid__header">
					<?php if (!empty($caption)) : ?>
						<div class="case-study-grid__caption">
							<?php echo esc_html($caption); ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($heading)) : ?>
						<div class="case-study-grid__heading">
							<?php echo $heading; ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($content)) : ?>
						<div class="case-study-grid__body">
							<?php echo $content; ?>
						</div>
					<?php endif; ?>
					<?php
						get_acf_components([
							'buttons' => [
								'data'    => $buttons,
								'classes' => 'case-study-grid__btns',
							],
						]);
					?>
				</div>
			<?php endif; ?>

			<?php if (!empty($case_studies)) : ?>
				<div class="case-study-grid__items js-case-study-grid-items">
					<?php foreach ($case_studies as $index => $case_study) : ?>
						<?php
							$title = $case_study['title'] ?? '';
							$media_type = $case_study['media_type'] ?? 'image';
							$image = $case_study['image'] ?? '';
							$svg_icon = $case_study['svg_icon'] ?? '';
							$video_url = $case_study['video_url'] ?? '';
							$company_logo = $case_study['company_logo'] ?? '';
							$case_study_url = $case_study['case_study_url'] ?? '#';
							$cta_text = $case_study['cta_text'] ?? 'Read Case Study';
							$has_metric = $case_study['has_metric'] ?? false;
							$metric_value = $case_study['metric_value'] ?? '';
							$metric_description = $case_study['metric_description'] ?? '';

							// Set fallback image if none is selected for image media type
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
											'alt' => wp_strip_all_tags($title ?? 'Case study')
										];
									}
								}
							}

							// Set fallback for company logo if none is selected
							if (empty($company_logo) || !isset($company_logo['id'])) {
								$fallback_image_path = get_template_directory() . '/screenshot.jpg';
								$fallback_image_uri = get_template_directory_uri() . '/screenshot.jpg';
								if (file_exists($fallback_image_path)) {
									$fallback_attachment = attachment_url_to_postid($fallback_image_uri);
									if ($fallback_attachment) {
										$company_logo = ['id' => $fallback_attachment];
									} else {
										$company_logo = [
											'url' => $fallback_image_uri,
											'alt' => 'Company logo'
										];
									}
								}
							}

							// Item visibility class
							$item_class = $index >= $initial_display ? 'case-study-grid__item--hidden' : '';
						?>
						<div class="case-study-grid__item <?php echo esc_attr($item_class); ?>" data-index="<?php echo esc_attr($index); ?>">
							<?php if (!empty($company_logo)) : ?>
								<div class="case-study-grid__logo-wrapper">
									<?php
										if (!empty($company_logo['id'])) {
											echo wp_get_attachment_image(
												$company_logo['id'],
												'medium',
												false,
												[
													'class' => 'case-study-grid__logo',
													'loading' => 'lazy',
												]
											);
										} elseif (!empty($company_logo['url'])) {
											echo '<img class="case-study-grid__logo" src="' . esc_url($company_logo['url']) . '" alt="' . esc_attr($company_logo['alt'] ?? 'Company logo') . '" loading="lazy" />';
										}
									?>
								</div>
							<?php endif; ?>

							<div class="case-study-grid__content">
								<?php if (!empty($title)) : ?>
									<h3 class="case-study-grid__title">
										<?php echo $title; ?>
									</h3>
								<?php endif; ?>

								<?php if (!empty($case_study_url)) : ?>
									<a href="<?php echo esc_url($case_study_url); ?>" class="case-study-grid__link">
										<?php echo esc_html($cta_text); ?>
										<svg class="case-study-grid__arrow" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M14 5L21 12M21 12L14 19M21 12H3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</a>
								<?php endif; ?>

								<?php if ($has_metric && (!empty($metric_value) || !empty($metric_description))) : ?>
									<div class="case-study-grid__metric">
										<div class="case-study-grid__metric-divider"></div>
										<div class="case-study-grid__metric-container">
											<?php if (!empty($metric_value)) : ?>
												<div class="case-study-grid__metric-value">
													<?php echo esc_html($metric_value); ?>
												</div>
											<?php endif; ?>
											<?php if (!empty($metric_description)) : ?>
												<div class="case-study-grid__metric-description">
													<?php echo esc_html($metric_description); ?>
												</div>
											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<?php if ($show_load_more && $has_hidden_items) : ?>
					<div class="case-study-grid__load-more-wrapper">
						<button class="case-study-grid__load-more js-case-study-load-more" data-total="<?php echo esc_attr($total_case_studies); ?>" data-shown="<?php echo esc_attr($initial_display); ?>">
							<?php echo esc_html($load_more_text); ?>
							<svg class="case-study-grid__arrow" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M14 5L21 12M21 12L14 19M21 12H3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</button>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
