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
			->addText('caption', [
				'label' => 'Caption',
				'instructions' => 'Short text above the heading',
				'default_value' => 'Tagline',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
				'default_value' => 'Short heading goes here',
			])
			->addWysiwyg('content', [
				'label' => 'Body Content',
				'instructions' => 'Enter the main content text.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => 'Ornare purus enim pulvinar at volutpat. Arcu lobortis elementum eu consectetur. Diam proin et senectus condimentum imperdiet vitae nisi. Velit habitasse odio libero.',
			])
			->addField('buttons', 'clone', [
				'clone' => [
					'group_buttons',
				]
			])
			->addRadio('item_style', [
				'label' => 'Item Style',
				'instructions' => 'Select the style for the grid items',
				'choices' => [
					'with-icons' => 'With Icons (Smaller)',
					'with-images' => 'With Images (Larger)'
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
				->addText('badge_label', [
					'label' => 'Badge Label',
					'instructions' => 'Optional label badge to show above item heading',
					'default_value' => 'Label',
				])
				->addWysiwyg('item_heading', [
					'label' => 'Item Heading',
					'instructions' => 'Heading for this grid item',
					'media_upload' => 0,
					'toolbar' => 'basic',
					'tabs' => 'visual',
					'delay' => 0,
					'default_value' => 'Medium length section heading goes here',
				])
				->addWysiwyg('item_content', [
					'label' => 'Item Content',
					'instructions' => 'Main content for this grid item',
					'media_upload' => 0,
					'toolbar' => 'full',
					'tabs' => 'all',
					'delay' => 0,
					'default_value' => 'Ornare purus enim pulvinar at volutpat. Arcu lobortis elementum eu consectetur. Diam proin et senectus condimentum imperdiet vitae nisi. Velit habitasse odio libero.',
				])
				->addField('item_buttons', 'clone', [
					'clone' => [
						'group_buttons',
					],
					'prefix_name' => 1,
				])
				->addRadio('media_type', [
					'label' => 'Media Type',
					'choices' => [
						'image' => 'Image',
						'svg' => 'SVG Icon',
					],
					'default_value' => 'image',
					'layout' => 'horizontal',
					'return_format' => 'value',
				])
				->addImage('image', [
					'label' => 'Image',
					'instructions' => 'Upload an image (jpg, png)',
					'return_format' => 'array',
					'preview_size' => 'medium',
					'conditional_logic' => [
						[
							[
								'field' => 'media_type',
								'operator' => '==',
								'value' => 'image',
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
								'field' => 'media_type',
								'operator' => '==',
								'value' => 'svg',
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
