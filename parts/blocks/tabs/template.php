<?php /*
	Block Name: Tabs
	Block Align: center
	Block Icon: table-row-after
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
		$tabs            = $group['tabs'] ?? [];
		$has_background  = $group['has_background'] ?? false;
		$background_color = $group['background_color'] ?? 'light';

		// Ensure we have at least 2 tabs
		if (count($tabs) < 2) {
			$tabs = [
				[
					'tab_title' => 'Tab 1',
					'tab_heading' => 'Tab 1 heading',
					'tab_content' => 'Tab 1 content',
					'media_type' => 'image',
					'media_description' => 'Description of the asset',
				],
				[
					'tab_title' => 'Tab 2',
					'tab_heading' => 'Tab 2 heading',
					'tab_content' => 'Tab 2 content',
					'media_type' => 'image',
					'media_description' => 'Description of the asset',
				]
			];
		}

		// Section classes
		$classes = ['l-section', 'l-section--tabs', 'js-tabs'];
		if ($has_background) {
			$classes[] = 'is-' . $background_color;
		}
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="tabs">
		<div class="tabs l-wrapper">
			<?php if (!empty($caption) || !empty($heading) || !empty($content)) : ?>
				<div class="tabs__header">
					<?php if (!empty($caption)) : ?>
						<div class="tabs__caption">
							<?php echo esc_html($caption); ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($heading)) : ?>
						<div class="tabs__heading">
							<?php echo $heading; ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($content)) : ?>
						<div class="tabs__body">
							<?php echo $content; ?>
						</div>
					<?php endif; ?>
					<?php
						get_acf_components([
							'buttons' => [
								'data'    => $buttons,
								'classes' => 'tabs__btns',
							],
						]);
					?>
				</div>
			<?php endif; ?>

			<div class="tabs__container js-tabs-container">
				<div class="tabs__navigation">
					<div class="tabs__nav-container">
						<?php foreach ($tabs as $index => $tab) : ?>
							<button id="tab-button-<?php echo esc_attr($index); ?>"
									class="tabs__nav-button js-tab-button <?php echo $index === 0 ? 'is-active' : ''; ?>"
									aria-controls="tab-content-<?php echo esc_attr($index); ?>"
									aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
									tabindex="<?php echo $index === 0 ? '0' : '-1'; ?>"
									role="tab">
								<?php echo esc_html($tab['tab_title']); ?>
							</button>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="tabs__content-wrapper">
					<?php foreach ($tabs as $index => $tab) : ?>
						<?php
							$tab_title = $tab['tab_title'] ?? 'Tab';
							$tab_heading = $tab['tab_heading'] ?? '';
							$tab_content = $tab['tab_content'] ?? '';
							$tab_buttons = $tab['tab_buttons_group'] ?? [];
							$media_type = $tab['media_type'] ?? 'image';
							$image = $tab['image'] ?? '';
							$video_group = $tab['video_group'] ?? [];
							$media_description = $tab['media_description'] ?? '';
							$show_key_metric = $tab['show_key_metric'] ?? false;
							$metric_logo = $tab['metric_logo'] ?? '';
							$metric_text = $tab['metric_text'] ?? '';
							$badge_label = $tab['badge_label'] ?? '';

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
											'alt' => wp_strip_all_tags($tab_heading ?? $tab_title)
										];
									}
								}
							}
						?>

						<div id="tab-content-<?php echo esc_attr($index); ?>"
							class="tabs__content js-tab-content <?php echo $index === 0 ? 'is-active' : ''; ?>"
							aria-labelledby="tab-button-<?php echo esc_attr($index); ?>"
							role="tabpanel"
							tabindex="0"
							<?php echo $index !== 0 ? 'hidden' : ''; ?>>

							<div class="tabs__content-inner">
								<div class="tabs__text-side">
									<?php if (!empty($badge_label)) : ?>
										<div class="tabs__badge">
											<?php echo esc_html($badge_label); ?>
										</div>
									<?php endif; ?>

									<?php if (!empty($tab_heading)) : ?>
										<div class="tabs__tab-heading">
											<?php echo $tab_heading; ?>
										</div>
									<?php endif; ?>

									<?php if (!empty($tab_content)) : ?>
										<div class="tabs__tab-content">
											<?php echo $tab_content; ?>
										</div>
									<?php endif; ?>

									<?php
										get_acf_components([
											'buttons' => [
												'data'    => $tab_buttons,
												'classes' => 'tabs__tab-btns',
											],
										]);
									?>

									<?php if ($show_key_metric) : ?>
										<div class="tabs__metric">
											<?php if (!empty($metric_logo) && isset($metric_logo['id'])) : ?>
												<div class="tabs__metric-logo">
													<?php echo wp_get_attachment_image($metric_logo['id'], 'thumbnail'); ?>
												</div>
											<?php endif; ?>
											<?php if (!empty($metric_text)) : ?>
												<div class="tabs__metric-text">
													<?php echo esc_html($metric_text); ?>
												</div>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>

								<div class="tabs__media-side">
									<?php if ($media_type === 'image') : ?>
										<div class="tabs__media-container">
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
															'alt'     => $image['alt'] ? $image['alt'] : wp_strip_all_tags($tab_heading ?? $tab_title),
															'class'   => 'tabs__img',
															'loading' => 'lazy',
														],
													);
												} elseif (!empty($image['url'])) {
													echo '<img class="tabs__img" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" loading="lazy" />';
												}
											?>
											<?php if (!empty($media_description)) : ?>
												<div class="tabs__media-description">
													<?php echo esc_html($media_description); ?>
												</div>
											<?php endif; ?>
										</div>
									<?php elseif ($media_type === 'video' && !empty($video_group)) : ?>
										<div class="tabs__media-container">
											<?php
												// When using the video from video_group
												if (isset($video_group['video_file']) || isset($video_group['video_url'])) {
													get_acf_components([
														'video' => [
															'data'    => $video_group,
															'classes' => 'tabs__video',
														]
													]);
												}
											?>
											<?php if (!empty($media_description)) : ?>
												<div class="tabs__media-description">
													<?php echo esc_html($media_description); ?>
												</div>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const tabContainers = document.querySelectorAll('.js-tabs-container');

			tabContainers.forEach(container => {
				const tabButtons = container.querySelectorAll('.js-tab-button');
				const tabContents = container.querySelectorAll('.js-tab-content');

				function setActiveTab(index) {
					// Update tab buttons state
					tabButtons.forEach((button, i) => {
						button.classList.toggle('is-active', i === index);
						button.setAttribute('aria-selected', i === index ? 'true' : 'false');
						button.setAttribute('tabindex', i === index ? '0' : '-1');
					});

					// Update tab content state
					tabContents.forEach((content, i) => {
						content.classList.toggle('is-active', i === index);
						if (i === index) {
							content.removeAttribute('hidden');
						} else {
							content.setAttribute('hidden', '');
						}
					});
				}

				// Add click event listeners to tab buttons
				tabButtons.forEach((button, index) => {
					button.addEventListener('click', () => {
						setActiveTab(index);
					});

					// Add keyboard navigation
					button.addEventListener('keydown', (e) => {
						let newIndex = index;

						switch (e.key) {
							case 'ArrowLeft':
								newIndex = index > 0 ? index - 1 : tabButtons.length - 1;
								e.preventDefault();
								break;
							case 'ArrowRight':
								newIndex = index < tabButtons.length - 1 ? index + 1 : 0;
								e.preventDefault();
								break;
							case 'Home':
								newIndex = 0;
								e.preventDefault();
								break;
							case 'End':
								newIndex = tabButtons.length - 1;
								e.preventDefault();
								break;
						}

						if (newIndex !== index) {
							setActiveTab(newIndex);
							tabButtons[newIndex].focus();
						}
					});
				});
			});
		});
	</script>
<?php endif; ?>
