<?php
	$button      = $args['data'] ?? [];
	$btn_classes = $args['classes'] ?? '';
	$tag         = $args['tag'] ?? 'a';

	$btn_classes .= ' btn--'.$button['type'];
	$btn_classes .= $button['size'] !== 'default' ? ' btn--'.$button['size'] : '';
	$btn          = $button['button'] ?? [];
	$link         = $btn['url'] ?? '';
	$title        = $btn['title'] ?? '';
	$target       = isset($btn['target']) ? 'target="'.$btn['target'].'"' : '';
	$has_icon     = $button['has_icon'] ?? 'n';
	$icon_position = $button['icon_position'] ?? 'right';
	$btn_classes .= !empty($button['has_icon']) ? ($icon_position === 'left' ? ' is-reverse' : '') : '';
	$icon         = $button['icon'] ?? '';
?>

<<?php echo $tag; ?> class="btn <?php echo $btn_classes; ?>" href="<?php echo $link; ?>" title="<?php echo 'Go to - '.$title;?>" <?php echo $target; ?>>
	<span class="text"><?php echo $title; ?></span>
	<?php if($has_icon === 'y') : ?>
		<span class="btn__icon">
			<?php
				if(!empty($icon)) {
					echo file_get_contents($icon['url']);
				} else{
					get_icon('arrow-right', [
					'classes' => $icon_position === 'left' ? 'is-rotated' : '',
					]);
				}
			?>
		</span>
	<?php endif; ?>
</<?php echo $tag; ?>>
