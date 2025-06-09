<?php
	use StoutLogic\AcfBuilder\FieldsBuilder;
	$path = basename(__DIR__);
	$name = str_replace('-', '_', $path);
	$group_name = $name . '_group';
	$group_label = str_replace('-', ' ', $path);
	$name = new FieldsBuilder($name);
	$name
		->addGroup($group_name, [
			'label' => ucwords($group_label) . ' Block',
			'instructions' => '',
			'layout' => 'block',
		])
			->addField('section_settings', 'clone', [
				'clone' => [
					'group_section_settings',
				]
			])
			->addButtonGroup('mode_variant', [
				'label'   => 'Color Mode Variant',
				'choices' => [
					'primary' => 'Primary',
					'secondary'  => 'Secondary',
				],
				'default_value' => 'primary',
				'layout'        => 'horizontal',
				'return_format' => 'value',
			])
			->addButtonGroup('image_position', [
				'label'   => 'Image Position',
				'choices' => [
					'left' => 'Left',
					'center'  => 'Center',
					'right' => 'Right',
				],
				'default_value' => 'center',
				'layout'        => 'horizontal',
				'return_format' => 'value',
			])
			->addField('heading', 'clone', [
				'clone' => [
					'group_heading_box',
				]
					])
			->addField('buttons', 'clone', [
				'clone' => [
					'group_action_group',
				],
			])
			->addGroup('comparison_images', [
				'label' => 'Comparison Images',
				'instructions' => 'Upload the before and after images',
				'layout' => 'block',
			])
				->addImage('before_image', [
					'label' => 'Before Image',
					'instructions' => 'Recommended size: 1952px x 1016px (976px x 508px × 2 for retina)',
					'return_format' => 'array',
					'preview_size' => 'medium',
					'required' => 1,
				])
				->addImage('after_image', [
					'label' => 'After Image',
					'instructions' => 'Recommended size: 1952px x 1016px (976px x 508px × 2 for retina)',
					'return_format' => 'array',
					'preview_size' => 'medium',
					'required' => 1,
				])
				->addText('before_button_text', [
					'label' => 'Before Button Text',
					'instructions' => 'Text for the before button',
					'default_value' => 'Before',
				])
				->addText('after_button_text', [
					'label' => 'After Button Text',
					'instructions' => 'Text for the after button',
					'default_value' => 'After',
				])
			->endGroup()
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
