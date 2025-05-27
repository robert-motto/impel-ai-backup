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
	->addField('heading', 'clone', [
				'clone' => [
		'group_heading_box',
				]
			])
			->addRadio('item_style', [
				'label' => 'Item Style',
				'instructions' => 'Select the style for the grid items',
				'choices' => [
		'with-icons' => 'With Icons',
		'with-images' => 'With Images'
				],
				'default_value' => 'with-icons',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addRadio('columns_count', [
				'label' => 'Number of Columns',
				'instructions' => 'Select number of columns to display on desktop',
				'choices' => [
					'2' => '2 Columns',
					'3' => '3 Columns'
				],
				'default_value' => '3',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addRepeater('grid_items', [
				'label' => 'Grid Items',
				'instructions' => 'Add items to display in the grid',
				'min' => 1,
				'layout' => 'block',
				'button_label' => 'Add Item',
			])
	->addText('item_heading', [
					'label' => 'Item Heading',
					'instructions' => 'Heading for this grid item',
	'maxlength' => 124,
				])
	->addTextarea('item_content', [
					'label' => 'Item Content',
					'instructions' => 'Main content for this grid item',
	'rows' => 8,
	'maxlength' => 228,
				])
	->addLink('item_link', [
		'label' => 'Item Link',
		'instructions' => 'Link for this grid item',
		'return_format' => 'array',
				])
				->addImage('image', [
					'label' => 'Image',
					'instructions' => 'Upload an image (jpg, png)',
					'return_format' => 'array',
					'preview_size' => 'medium',
					'conditional_logic' => [
						[
							[
				'field' => 'item_style',
								'operator' => '==',
				'value' => 'with-images',
							]
						]
					]
				])
				->addImage('svg_icon', [
					'label' => 'SVG Icon',
					'instructions' => 'Upload an SVG icon',
					'return_format' => 'array',
					'preview_size' => 'thumbnail',
					'mime_types' => 'svg',
					'conditional_logic' => [
						[
							[
				'field' => 'item_style',
								'operator' => '==',
				'value' => 'with-icons',
							]
						]
					]
				])
			->endRepeater()
			->addTrueFalse('has_background', [
				'label' => 'Use Background Color',
				'instructions' => 'Add background color to the section',
				'default_value' => 0,
				'ui' => 1,
			])
			->addSelect('background_color', [
				'label' => 'Background Color',
				'instructions' => 'Select background color',
				'choices' => [
					'light' => 'Light (Gray)',
					'white' => 'White',
					'dark' => 'Dark',
				],
				'default_value' => 'light',
				'return_format' => 'value',
				'multiple' => 0,
				'ui' => 1,
			])
				->conditional('has_background', '==', 1)
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
