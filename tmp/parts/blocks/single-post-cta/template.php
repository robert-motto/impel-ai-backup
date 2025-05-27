<?php /*
	Block Name: Post CTA
	Block Align: center
	Block Icon: megaphone
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group        = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);

		$mode       = $group['mode'] ?? 'is-dark';
		$heading    = $group['heading_group'] ?? [];
		$content    = $group['content_group'] ?? [];
		$buttons    = $group['buttons_group'] ?? [];
	?>
	<div class="block-post-cta <?php echo $mode; ?> block-mb-large">
		<div class="block-post-cta__content-hld">
			<?php
				get_acf_components([
					'heading' => [
						'data'    => $heading,
						'classes' => 'block-post-cta__heading',
					],
					'content' => [
						'data'    => $content,
						'classes' => 'block-post-cta__content',
					],
				]);
			?>
		</div>
		<?php
			get_acf_component('buttons', [
				'data'    => $buttons,
				'classes' => 'block-post-cta__buttons',
			]);
		?>
	</div>
<?php endif; ?>
