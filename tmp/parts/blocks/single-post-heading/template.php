
<?php /*
	Block Name: Post Heading
	Block Align: center
	Block Icon: heading
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group        = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);

		$heading    = $group['heading_group'] ?? [];
	?>
	<?php
		get_acf_component('heading', [
			'data'    => $heading,
			'classes' => 'block-post-heading',
		]);
	?>
<?php endif; ?>
