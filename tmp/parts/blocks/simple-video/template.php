<?php /*
	Block Name: Simple simple-video
	Block Align: center
	Block Icon: embed-video
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group        = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);

		$video             = $group['video_group'] ?? [];
		$heading 		   = $group['heading_group'] ?? [];
		$content           = $group['content_group'] ?? [];
		$buttons    	   = $group['buttons_group'] ?? [];
		$padding_bottom    = $group['section_settings_group']['pb'] ?? 'pb-lg';
	?>
	<section <?php echo section_settings_id($group); ?> class="l-section l-section--simple-video <?php echo section_settings_classes($group); ?>" data-block="simple-video">
		<div class="simple-video l-wrapper">
			<?php if (!empty($heading['title']) || !empty($content['content'])) : ?>
				<div class="simple-video__header-hld">
					<?php get_acf_components([
						'heading' => [
							'data'    => $heading,
							'classes' => 'simple-video__heading',
						],
						'content' => [
							'data'    => $content,
							'classes' => 'simple-video__content',
						],
						'buttons' => [
							'data'    => $buttons,
							'classes' => 'simple-video__buttons',
						],
					]); ?>
				</div>
			<?php endif; ?>
			<?php get_acf_component('video', [
				'data'    => $video,
				'classes' => $padding_bottom,
			]); ?>
		</div>
	</section>
<?php endif; ?>
