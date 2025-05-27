
<?php /*
	Block Name: Post Subheading
	Block Align: center
	Block Icon: heading
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group        = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);

		$subheading    = $group['subheading_group'] ?? [];
	?>
	<?php
		get_acf_component('subheading', [
			'data'    => $subheading,
			'classes' => 'block-post-subheading',
		]);
	?>
<?php endif; ?>

