<?php
	$data					= $args['data'] ?? '';

	$alignment		= $data['alignment'] ?? 'central';
	$caption			= $data['caption'] ?? '';
	$heading			= $data['heading'] ?? '';
	$heading_size	= $data['heading_size'] ?? 'regular';
	$subheading		= $data['subheading'] ?? '';
?>

<?php if (!empty($caption) || !empty($heading) || !empty($subheading)) : ?>
	<div class="heading-box heading-box--<?php echo $alignment; ?> heading-box--<?php echo $heading_size; ?>">
		<?php if (!empty($caption)) : ?>
			<div class="heading-box__caption">
				<?php echo esc_html($caption); ?>
			</div>
		<?php endif; ?>
		<?php if (!empty($heading)) : ?>
			<div class="heading-box__heading">
				<?php echo $heading; ?>
			</div>
		<?php endif; ?>
		<?php if (!empty($subheading)) : ?>
			<div class="heading-box__subheading">
				<?php echo $subheading; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
