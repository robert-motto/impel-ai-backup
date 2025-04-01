<?php /*
	Block Name: Post Content with Background
	Block Align: center
	Block Icon: editor-paragraph
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group        = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);

		$heading    = $group['heading_group'] ?? [];
		$content    = $group['content_group'] ?? [];
		$margin_size = $group['margin_size'] ?? 'block-mb-default';
	?>
	<div class="block-post-content-bg <?php echo $margin_size; ?>">
		<?php
			get_acf_components([
				'heading' => [
					'data' => $heading,
					'classes' => 'block-post-content-bg__heading',
				],
				'content' => [
					'data' => $content,
					'classes' => 'block-post-content-bg__content',
				],
			]);
		?>
	</div>
<?php endif; ?>
