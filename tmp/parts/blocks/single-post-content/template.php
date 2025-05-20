<?php /*
	Block Name: Post Content
	Block Align: center
	Block Icon: editor-paragraph
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);

		$content = $group['content_group'] ?? [];
	?>
	<?php
		get_acf_component('content', [
			'data'    => $content,
			'classes' => 'block-post-content',
		]);
	?>
<?php endif; ?>
