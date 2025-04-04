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
				'default_value' => 'AI Insights',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
				'default_value' => 'Latest Resources',
			])
			->addWysiwyg('content', [
				'label' => 'Body Content',
				'instructions' => 'Enter the optional description text.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => '',
			])
			->addField('buttons_group', 'clone', [
				'label' => 'Buttons',
				'instructions' => 'Add "View all resources" button or other call-to-action buttons',
				'clone' => [
					'group_buttons',
				],
				'default_value' => [
					'has_buttons' => 'y',
					'buttons' => [
						[
							'button_group' => [
								'button_type' => 'link',
								'button_size' => 'default',
								'link' => [
									'title' => 'View all resources',
									'url' => '#',
									'target' => '',
								],
								'display_icon' => 1
							]
						]
					]
				],
				'display' => 'seamless',
			])
			->addRepeater('items', [
				'label' => 'Shortlist Items',
				'instructions' => 'Add items to the shortlist',
				'layout' => 'block',
				'button_label' => 'Add Item',
				'min' => 1,
				'max' => 3,
			])
				->addImage('thumbnail', [
					'label' => 'Thumbnail',
					'instructions' => 'Upload or select an image (recommended size: 400x250px)',
					'return_format' => 'array',
					'preview_size' => 'medium',
					'library' => 'all',
					'required' => 1,
				])
				->addText('category', [
					'label' => 'Category',
					'instructions' => 'Enter the category of the item (e.g., Article, News)',
					'default_value' => 'Article',
				])
				->addText('title', [
					'label' => 'Title',
					'instructions' => 'Enter the title of the item',
					'required' => 1,
					'default_value' => 'The Transformative Impact of AI in the Automotive Industry',
				])
				->addText('reading_time', [
					'label' => 'Reading Time',
					'instructions' => 'Enter the reading time (e.g., "5 min")',
					'default_value' => '5 min',
				])
				->addLink('link', [
					'label' => 'Link',
					'instructions' => 'Add a link to the full resource',
					'return_format' => 'array',
					'required' => 1,
				])
			->endRepeater()
			->addTrueFalse('has_background', [
				'label' => 'Use Background Color',
				'instructions' => 'Add background color to the section',
				'default_value' => 1,
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
				'conditional_logic' => [
					[
						[
							'field' => 'has_background',
							'operator' => '==',
							'value' => 1,
						]
					]
				]
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
