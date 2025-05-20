<?php /*
	Block Name: General Form
	Block Align: center
	Block Icon: forms
*/ ?>
<?php if (isset($block['data']['is_preview'])) :?>
	<?php block_preview(__FILE__); ?>
<?php else :?>
	<?php
		$group = isset($args['data']) ? $args['data'] : blockFieldGroup(__FILE__);
		$heading = $group['heading'] ?? '';
		$content = $group['content'] ?? '';
		$gravity_form_id = $group['gravity_form_id'] ?? '';
		$add_background = $group['add_background'] ?? true;
		$background_color = $group['background_color'] ?? 'light';

		$classes = ['l-section', 'l-section--general-form', 'js-general-form'];

		if ($add_background) {
			$classes[] = 'is-' . $background_color;
		}
	?>
	<section <?php echo section_settings_id($group); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="general-form">
		<div class="general-form l-wrapper">
			<div class="general-form__content">
				<?php if (!empty($heading)) : ?>
					<h2 class="general-form__heading">
						<?php echo esc_html($heading); ?>
					</h2>
				<?php endif; ?>

				<?php if (!empty($content)) : ?>
					<div class="general-form__description">
						<?php echo $content; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if (!empty($gravity_form_id)) : ?>
				<div class="general-form__form-container">
					<?php
						if (function_exists('gravity_form')) {
							gravity_form(
								$gravity_form_id,
								false,  // display title
								false,  // display description
								false,  // display inactive
								null,   // field values
								true,   // AJAX
								0,      // tabindex
								true    // echo
							);
						} else {
							echo '<p>Gravity Forms plugin is not active.</p>';
						}
					?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
