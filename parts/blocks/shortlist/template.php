<?php /*
	Block Name: Shortlist
	Block Align: center
	Block Icon: list-view
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group           = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$caption         = $group['caption'] ?? '';
		$heading         = $group['heading'] ?? '';
		$content         = $group['content'] ?? '';
		$items           = $group['items'] ?? [];
		$has_background  = $group['has_background'] ?? true;
		$background_color = $group['background_color'] ?? 'light';

		// Get buttons - use same format as content-block-left-right
		$buttons = $group['buttons_group'] ?? [];

		// Section classes
		$classes = ['l-section', 'l-section--shortlist', 'js-shortlist'];
		if ($has_background) {
			$classes[] = 'is-' . $background_color;
		}
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="shortlist">
		<div class="l-wrapper">
			<div class="shortlist">
				<div class="shortlist__header">
					<?php if (!empty($caption)) : ?>
						<div class="shortlist__caption">
							<?php echo esc_html($caption); ?>
						</div>
					<?php endif; ?>

					<?php if (!empty($heading)) : ?>
						<h2 class="shortlist__heading">
							<?php echo $heading; ?>
						</h2>
					<?php endif; ?>

					<?php
						get_acf_components([
							'buttons' => [
								'data'    => $buttons,
								'classes' => 'shortlist__buttons',
							],
						]);
					?>
				</div>

				<?php if (!empty($content)) : ?>
					<div class="shortlist__content">
						<?php echo $content; ?>
					</div>
				<?php endif; ?>

				<?php if (!empty($items)) : ?>
					<div class="shortlist__items">
						<?php foreach ($items as $item) :
							$thumbnail = $item['thumbnail'] ?? '';
							$category = $item['category'] ?? '';
							$title = $item['title'] ?? '';
							$reading_time = $item['reading_time'] ?? '';
							$link = $item['link'] ?? '';

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
											'alt' => wp_strip_all_tags($title ?? 'Shortlist item')
										];
									}
								}
							}
						?>
							<div class="shortlist__item">
								<?php if (!empty($link) && !empty($link['url'])) : ?>
									<a href="<?php echo esc_url($link['url']); ?>" class="shortlist__item-link" <?php echo !empty($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
								<?php endif; ?>

								<div class="shortlist__item-media">
									<?php
										if (!empty($thumbnail['id'])) {
											echo bis_get_attachment_picture(
												$thumbnail['id'],
												[
													560  => [ 400, 250, 1 ],
													1024 => [ 400, 250, 1 ],
													1920 => [ 400, 250, 1 ],
													2800 => [ 800, 500, 1 ],
												],
												[
													'alt'     => $thumbnail['alt'] ? $thumbnail['alt'] : wp_strip_all_tags($title ?? ''),
													'class'   => 'shortlist__item-img',
													'loading' => 'lazy',
												],
											);
										} elseif (!empty($thumbnail['url'])) {
											echo '<img class="shortlist__item-img" src="' . esc_url($thumbnail['url']) . '" alt="' . esc_attr($thumbnail['alt']) . '" loading="lazy" />';
										}
									?>
								</div>

								<div class="shortlist__item-content">
									<div class="shortlist__item-meta">
										<?php if (!empty($category)) : ?>
											<div class="shortlist__item-category">
												<?php echo esc_html($category); ?>
											</div>
										<?php endif; ?>

										<div class="shortlist__item-divider"></div>

										<?php if (!empty($reading_time)) : ?>
											<div class="shortlist__item-time">
												<span class="shortlist__item-time-icon">
													<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
														<circle cx="8" cy="8" r="7" stroke="#666666" stroke-width="1"/>
														<path d="M8 4V8H11" stroke="#666666" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>
												</span>
												<span class="shortlist__item-time-text"><?php echo esc_html($reading_time); ?></span>
											</div>
										<?php endif; ?>
									</div>

									<?php if (!empty($title)) : ?>
										<h3 class="shortlist__item-title">
											<?php echo esc_html($title); ?>
										</h3>
									<?php endif; ?>
								</div>

								<?php if (!empty($link) && !empty($link['url'])) : ?>
									</a>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
