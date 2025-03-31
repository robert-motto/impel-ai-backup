<?php /*
	Block Name: Hero
	Block Align: center
	Block Icon: superhero-alt
*/ ?>

<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group      = blockFieldGroup(__FILE__);
		$heading    = $group['heading_group'] ?? [];
		$title      = $heading['title'] ?? '';
		$subheading = $group['subheading_group'] ?? [];
		$content    = $group['content_group'] ?? [];
		$buttons    = $group['buttons_group'] ?? [];
		$image      = $group['image'];
	?>
	<section class="l-section l-section--hero is-light" data-block="hero">
		<div class="hero">
			<?php if(!empty($image)) :?>
				<div class="hero__image">
					<?php
						if(!empty($image)) {
							echo bis_get_attachment_picture(
								$image['id'],
								[
									560  => [ 390 * 2, 772 * 2, 1 ],
									1024 => [ 1024, 1474, 1 ],
									1365 => [ 1400, 760, 1 ],
									2800 => [ 1400 * 2, 760 * 2, 1 ],
								],
								[
									'alt'   => $image['alt'] ? $image['alt'] : wp_strip_all_tags($title),
									'class' => '',
								]
							);
						}
					?>
				</div>
			<?php endif; ?>
			<div class="hero__inner">
				<div class="l-wrapper">
					<div class="hero__text-hld">
						<?php
							get_acf_components([
								'heading' => [
									'data'    => $heading,
									'classes' => 'hero__heading',
								],
								'subheading' => [
									'data'    => $subheading,
									'classes' => 'hero__subheading',
								],
								'content' => [
									'data'    => $content,
									'classes' => 'hero__content',
								],
								'buttons' => [
									'data'    => $buttons,
									'classes' => 'hero__btns',
								],
							]);
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
