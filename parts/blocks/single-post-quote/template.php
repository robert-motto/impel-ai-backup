<?php /*
	Block Name: Post Quote
	Block Align: center
	Block Icon: format-quote
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group        = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);

		$content      = $group['content_group'] ?? [];
		$author       = $group['author'] ?? '';
		$author_title = $group['author_title'] ?? '';
	?>
	<div class="block-mb-large block-post-quote">
		<?php get_icon('quote', [
			'classes' => 'block-post-quote__icon',
		]); ?>
		<div class="block-post-quote__content">
			<?php
				get_acf_component('content', [
					'data'    => $content,
					'classes' => 'block-post-content',
				]);
			?>
			<?php if(!empty($author)) :?>
				<div class="block-post-quote__author">
					<?php if(!empty($author)) :?>
						<span class="block-post-quote__author__name t-heading t-heading--h8"><?php echo $author; ?></span>
					<?php endif; ?>
					<?php if(!empty($author_title)) :?>
						<span class="block-post-quote__author__title t-paragraph t-paragraph--4"><?php echo $author_title; ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
