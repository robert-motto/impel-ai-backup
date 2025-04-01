<?php /*
	Block Name: Hero Left
	Block Align: center
	Block Icon: superhero-alt
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group         = blockFieldGroup(__FILE__);
		$breadcrumbs   = $group['breadcrumbs'] ?? [];
		$caption       = $group['caption'] ?? '';
		$heading       = $group['heading'] ?? '';
		$subheading    = $group['subheading'] ?? '';
		$icon_points   = $group['icon_points'] ?? [];
		$buttons       = $group['buttons_group'] ?? [];
		$media_type    = $group['media_type'] ?? 'image'; // Default to image
		$image         = $group['image'] ?? null;
		$video_group   = $group['video_group'] ?? []; // Get video data if type is video
		$partner_logos = $group['partner_logos'] ?? [];

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
						'alt' => wp_strip_all_tags($heading ?? 'Hero image')
					];
				}
			}
		}

		// Section classes
		$classes = ['l-section', 'l-section--hero-left', 'js-hero-left'];
		if (!empty($group['section_settings_group']['background_color'])) {
			$classes[] = 'is-' . $group['section_settings_group']['background_color'];
		} else {
			$classes[] = 'is-light';
		}
	?>
	<section class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group);?>" data-block="hero-left">
		<div class="l-wrapper">
			<?php if (!empty($breadcrumbs)) : ?>
				<nav class="hero-left__breadcrumbs" aria-label="Breadcrumb">
					<ol>
						<?php foreach ($breadcrumbs as $key => $breadcrumb) : ?>
							<?php $is_last = (count($breadcrumbs) - 1) === $key; ?>
							<li class="hero-left__breadcrumb <?php echo $is_last ? 'hero-left__breadcrumb--current' : ''; ?>">
								<?php if (!$is_last && !empty($breadcrumb['link'])) : ?>
									<a href="<?php echo esc_url($breadcrumb['link']); ?>"><?php echo esc_html($breadcrumb['label']); ?></a>
									<span class="hero-left__breadcrumb-separator">&gt;</span>
								<?php else : ?>
									<span aria-current="page"><?php echo esc_html($breadcrumb['label']); ?></span>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ol>
				</nav>
			<?php endif; ?>
			<div class="hero-left">
				<div class="hero-left__content">
					<div class="hero-left__text-hld">
						<?php if (!empty($caption)) : ?>
							<div class="hero-left__caption">
								<?php echo esc_html($caption); ?>
							</div>
						<?php endif; ?>
						<?php if (!empty($heading)) : ?>
							<h1 class="hero-left__heading">
								<?php echo $heading; ?>
							</h1>
						<?php endif; ?>
						<?php if (!empty($subheading)) : ?>
							<div class="hero-left__subheading">
								<?php echo $subheading; ?>
							</div>
						<?php endif; ?>
						<?php if (!empty($icon_points)) : ?>
							<ul class="hero-left__points">
								<?php foreach ($icon_points as $point) : ?>
									<li class="hero-left__point">
										<div class="hero-left__point-icon">
											<?php include(get_template_directory() . '/parts/icons/check-circle.php'); ?>
										</div>
										<span class="hero-left__point-text"><?php echo esc_html($point['text']); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<?php
							get_acf_components([
								'buttons' => [
									'data'    => $buttons,
									'classes' => 'hero-left__btns',
								],
							]);
						?>
					</div>
					<div class="hero-left__media-hld">
						<?php if ($media_type === 'image') : ?>
							<?php
								if (!empty($image['id'])) {
									echo bis_get_attachment_picture(
										$image['id'],
										[
											560  => [ 390 * 2, 772 * 2, 1 ],
											1024 => [ 1024, 1474, 1 ],
											1365 => [ 1400, 760, 1 ],
											2800 => [ 1400 * 2, 760 * 2, 1 ],
										],
										[
											'alt'   => $image['alt'] ? $image['alt'] : wp_strip_all_tags($heading ?? ''),
											'class' => 'hero-left__image',
										]
									);
								} elseif (!empty($image['url'])) {
									echo '<img class="hero-left__image" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt'] ?? '') . '" />';
								}
							?>
						<?php elseif ($media_type === 'video' && !empty($video_group)) : ?>
							<?php
								get_acf_components([
									'video' => [
										'data'    => $video_group,
										'classes' => 'hero-left__video',
									]
								]);
							?>
						<?php endif; ?>
					</div>
				</div>
				<?php if (!empty($partner_logos)) : ?>
					<div class="hero-left__partners">
						<div class="hero-left__partners-divider"></div>
						<div class="hero-left__partners-logos">
							<?php foreach ($partner_logos as $logo) : ?>
								<?php if (!empty($logo['logo'])) : ?>
									<div class="hero-left__partner">
										<?php if (!empty($logo['logo']['id'])) : ?>
											<?php echo bis_get_attachment_picture(
												$logo['logo']['id'],
												[
													300 => [120, 60, 0],
													600 => [120 * 2, 60 * 2, 0],
												],
												[
													'alt' => !empty($logo['name']) ? esc_attr($logo['name']) . ' logo' : '',
													'class' => 'hero-left__partner-logo',
												]
											); ?>
										<?php elseif (!empty($logo['logo']['url'])) : ?>
											<img class="hero-left__partner-logo" src="<?php echo esc_url($logo['logo']['url']); ?>" alt="<?php echo !empty($logo['name']) ? esc_attr($logo['name']) . ' logo' : ''; ?>" />
										<?php endif; ?>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
