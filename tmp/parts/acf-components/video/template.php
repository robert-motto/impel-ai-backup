<?php
$classes       = $args['classes'] ?? '';
$video         = $args['data'];

$player        = $video['player'] ?? 'wp';
$embed_link    = $video['embed_link'] ?? '';
$embed_title   = $video['embed_title'] ?? '';
$file          = $video['file'] ?? '';
$photo         = $video['photo'] ?? '';

if (empty($photo)) {
	$fallback_image_path = get_template_directory() . '/screenshot.jpg';
	$fallback_image_uri = get_template_directory_uri() . '/screenshot.jpg';
	if (file_exists($fallback_image_path)) {
		$fallback_attachment = attachment_url_to_postid($fallback_image_uri);
		if ($fallback_attachment) {
			$photo = ['id' => $fallback_attachment];
		} else {
			$photo = [
				'url' => $fallback_image_uri,
				'alt' => 'video cover'
			];
		}
	}
}


$photo_sizes = [
	640  => [640, 360, 1],
	1920 => [1000, 563, 1],
	2800 => [1000 * 2, 563 * 2, 1],
];
?>
<div class="video__player is-paused <?php echo $classes; ?>">
	<div class="video__player__container">
		<?php if ($player === 'wp') : ?>
			<?php if (!empty($photo)) : ?>
				<video class="video__player__file js-video" data-src="<?php echo $file['url']; ?>" controls playsinline></video>
			<?php else : ?>
				<video class="video__player__file js-video is-active is-loaded" data-src="<?php echo $file['url']; ?>" controls playsinline>
					<source src="<?php echo $file['url']; ?>" type="video/mp4">
				</video>
			<?php endif; ?>
		<?php elseif ($player === 'youtube') :
			$youtube_id = embed_player_id($player, $embed_link);
		?>
			<div class="video__player__file js-video TEST" id="youtubePlayer-<?php echo $youtube_id; ?>" data-player-id="<?php echo $youtube_id; ?>"></div>
		<?php elseif ($player === 'vimeo') :
			$vimeo_id = embed_player_id($player, $embed_link);
		?>
			<iframe id="vimeoPlayer-<?php echo $vimeo_id; ?>" data-player-id="<?php echo $vimeo_id; ?>" class="video__player__file js-video" loading="lazy" title="<?php echo $embed_title; ?>" data-src="https://player.vimeo.com/video/<?php echo $vimeo_id; ?>?color=FF6947" width="500" height="281" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen=""></iframe>
		<?php endif; ?>
		<div class="video__player__cover js-video-btn-play" data-player="<?php echo $player; ?>">
			<?php if (!empty($photo) && !empty($photo['id'])) {
				echo bis_get_attachment_picture(
					$photo['id'],
					$photo_sizes,
					[
						'alt'     => $photo['alt'] ? $photo['alt'] : wp_strip_all_tags($embed_title),
						'class'   => 'video__player__cover__img',
						'loading' => 'lazy',
					]
				);
			} else { ?>
				<img class="video__player__cover__img" src="<?php echo esc_url($photo['url']); ?>" alt="<?php echo esc_attr($photo['alt'] ?? wp_strip_all_tags($person_name ?? 'video cover')); ?>" loading="lazy" />
			<?php } ?>
			<button type="button" class="video__player-btn">
				<?php get_icon('circle-play', [
					'classes' => 'video__player-btn__icon',
				]); ?>
				<span class="u-sr-only"><?php _e('Play', get_option('template')); ?></span>
			</button>
		</div>
	</div>
</div>