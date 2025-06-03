<?php
	$data							= $args['data'] ?? '';

	$alignment				= $data['alignment'] ?? 'central';
	$caption					= $data['caption'] ?? '';
	$heading					= $data['heading'] ?? '';
	$heading_size			= $data['heading_size'] ?? 'regular';
	$use_list_subheading 	= $data['use_list_subheading'] ?? false;
	$subheading				= $data['subheading'] ?? '';
	$subheading_list		= $data['subheading_list'] ?? [];
	$subheading_font_size = $data['subheading_font_size'] ?? 'regular';
?>

<?php if (!empty($caption) || !empty($heading) || !empty($subheading) || (!empty($subheading_list) && $use_list_subheading)) : ?>
	<div class="heading-box heading-box--<?php echo esc_attr($alignment); ?> heading-box--<?php echo esc_attr($heading_size); ?> js-heading-box">
		<?php if (!empty($caption)) : ?>
			<div class="heading-box__caption">
				<?php echo esc_html($caption); ?>
			</div>
		<?php endif; ?>
		<?php if (!empty($heading)) : ?>
			<div class="heading-box__heading">
				<?php echo wp_kses_post($heading); ?>
			</div>
		<?php endif; ?>

		<?php if ($use_list_subheading && !empty($subheading_list)) : ?>
			<ul class="heading-box__subheading-list">
				<?php foreach ($subheading_list as $item) : ?>
					<?php $list_item_text = $item['list_item'] ?? ''; ?>
					<?php if (!empty($list_item_text)) : ?>
						<li class="heading-box__subheading-list-item">
							<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none" aria-hidden="true" focusable="false">
								<circle cx="10.5" cy="14" r="10.5" fill="#6C44E4"/>
								<path d="M6.76172 14.1745L9.42839 16.8411L14.7617 11.5078" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<?php echo esc_html($list_item_text); ?>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<?php elseif (!$use_list_subheading && !empty($subheading)) : ?>
			<?php $subheading_classes = 'heading-box__subheading'; ?>
			<?php if ($subheading_font_size === 'small') : ?>
				<?php $subheading_classes .= ' heading-box__subheading--small'; ?>
			<?php endif; ?>
			<div class="<?php echo esc_attr($subheading_classes); ?>">
				<?php echo wp_kses_post(nl2br($subheading)); ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
