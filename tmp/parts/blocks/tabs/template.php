<?php /*
	Block Name: Tabs
	Block Align: center
	Block Icon: table-row-after
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group           		= isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$heading         		= $group['heading_box_group'] ?? '';
		$tabs            		= $group['tabs'] ?? [];
		$color_mode      		= $group['section_settings_group']['mode'] ?? 'light';
		$color_mode_variant	= $group['mode_variant'] ?? 'regular';

		// Section classes
		$classes = ['js-section', 'l-section', 'l-section--tabs', 'js-tabs', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}"];
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-block="tabs">
		<div class="tabs l-wrapper">

			<?php
				get_acf_component(
					'heading-box', [
						'data' => $heading,
					],
				);
			?>

			<div class="tabs__container js-tabs-container">
				<?php
					get_component('tab-bar', [
						'tabs' => $tabs,
					]);
				?>


				<div class="tabs__content-wrapper">
					<?php foreach ($tabs as $index => $tab) : ?>
						<?php
							$tab_title = $tab['tab_title'] ?? 'Tab';
							$tab_caption = $tab['tab_caption'] ?? '';
							$tab_heading = $tab['tab_heading'] ?? '';
							$tab_content = $tab['tab_content'] ?? '';
							$tab_buttons = $tab['action_group_group'] ?? [];
							$media_type = $tab['media_type'] ?? 'image';
							$image = $tab['image'] ?? '';
							$video_group = $tab['video_group'] ?? [];
							$media_description = $tab['media_description'] ?? '';
							$show_key_metric = $tab['show_key_metric'] ?? false;
							$metric_logo = $tab['metric_logo'] ?? '';
							$metric_logo_dark = $tab['metric_logo_dark'] ?? '';
							$metric_text = $tab['metric_text'] ?? '';
							$metric_icon = $tab['metric_icon'] ?? 'arrow-up';

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
									<?php if (!empty($tab_caption)) : ?>
										<div class="tabs__tab-caption">
											<?php echo esc_html($tab_caption); ?>
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
										get_acf_component(
											'action-group', [
												'data' => $tab_buttons,
												'classes' => 'tabs__tab-btns',
											],
										);
									?>

								</div>

								<div class="tabs__media-side">
									<?php if ($media_type === 'image') : ?>
										<div class="tabs__media-container">
											<?php
												if (!empty($image['id'])) {
													if (function_exists('bis_get_attachment_picture')) {
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
													} else {
														$img_src = wp_get_attachment_image_url($image['id'], 'large');
														$img_alt = get_post_meta($image['id'], '_wp_attachment_image_alt', true) ?: wp_strip_all_tags($tab_heading ?? $tab_title);
														echo '<img class="tabs__img" src="' . esc_url($img_src) . '" alt="' . esc_attr($img_alt) . '"  />';
													}
												} elseif (!empty($image['url'])) {
													echo '<img class="tabs__img" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '"  />';
												}
											?>

											<?php if ($show_key_metric) : ?>
												<div class="tabs__key-metric">
													<?php if (!empty($metric_logo) && isset($metric_logo['id'])) : ?>
														<div class="tabs__metric-logo">
															<?php echo wp_get_attachment_image($metric_logo['id'], 'thumbnail'); ?>
														</div>
													<?php endif; ?>
													<div class="tabs__metric-badge">
														<div class="tabs__metric-icon">
															<?php get_icon($metric_icon === 'arrow-up' ? 'arrow-up-right' : 'arrow-down-right'); ?>
														</div>
														<div class="tabs__metric-text">
															<?php echo esc_html($metric_text); ?>
														</div>
													</div>
												</div>
											<?php endif; ?>
										</div>
										<?php elseif ($media_type === 'video' && !empty($video_group)) : ?>
										<div class="tabs__media-container">
											<?php
													get_acf_component('video', [
														'data'    => $video_group['video_group'],
														'classes' => 'tabs__video',
													]);
											?>
											<?php if ($show_key_metric) : ?>
												<div class="tabs__key-metric">
													<?php if (!empty($metric_logo) && isset($metric_logo['id'])) : ?>
														<div class="tabs__metric-logo">
															<?php echo wp_get_attachment_image($metric_logo['id'], 'thumbnail'); ?>
														</div>
													<?php endif; ?>
													<div class="tabs__metric-badge">
														<div class="tabs__metric-icon">
															<?php get_icon($metric_icon === 'arrow-up' ? 'arrow-up-right' : 'arrow-down-right'); ?>
														</div>
														<div class="tabs__metric-text">
															<?php echo esc_html($metric_text); ?>
														</div>
													</div>
												</div>
											<?php endif; ?>

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

			function handleKeyboardNavigation(event, tabButtons, currentIndex) {
				const maxIndex = tabButtons.length - 1;
				let newIndex = currentIndex;

				// Handle keyboard navigation
				switch (event.key) {
					case 'ArrowRight':
					case 'ArrowDown':
						newIndex = currentIndex < maxIndex ? currentIndex + 1 : 0;
						break;
					case 'ArrowLeft':
					case 'ArrowUp':
						newIndex = currentIndex > 0 ? currentIndex - 1 : maxIndex;
						break;
					case 'Home':
						newIndex = 0;
						break;
					case 'End':
						newIndex = maxIndex;
						break;
					default:
						return;
				}

				event.preventDefault();
				tabButtons[newIndex].click();
				tabButtons[newIndex].focus();
			}

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
						const isActive = i === index;
						content.classList.toggle('is-active', isActive);

						if (isActive) {
							content.removeAttribute('hidden');
						} else {
							content.setAttribute('hidden', '');
						}
					});
				}

				// Add click event to each tab button
				tabButtons.forEach((button, index) => {
					button.addEventListener('click', () => {
						setActiveTab(index);
					});

					button.addEventListener('keydown', (event) => {
						handleKeyboardNavigation(event, tabButtons, index);
					});
				});
			});
		});
	</script>
<?php endif; ?>
