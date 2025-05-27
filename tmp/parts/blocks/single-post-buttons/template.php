<?php /*
	Block Name: Post Buttons
	Block Align: center
	Block Icon: button
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);

		$buttons     = $group['buttons_group'] ?? [];
		$margin_size = $group['margin_size'] ?? 'block-mb-default';
	?>
	<div class="block-post-buttons <?php echo $margin_size; ?>">
		<?php
			get_acf_component('buttons', [
				'data'    => $buttons,
				'classes' => 'block-post-buttons',
			]);
		?>
	</div>
<?php endif; ?>
