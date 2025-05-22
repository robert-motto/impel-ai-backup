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
			->addButtonGroup('layout_variant', [
				'label' => 'Layout Variant',
				'choices' => [
					'text-left' => 'Text Left',
					'text-right' => 'Text Right',
				],
				'default_value' => 'text-left',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addField('heading', 'clone', [
				'clone' => [
					'group_heading_box',
				]
			])
			->addRepeater('items', [
				'label' => 'Items',
				'instructions' => 'Add between 3 and 5 items.',
				'min' => 3,
				'max' => 5,
				'layout' => 'block',
				'button_label' => 'Add Item',
			])
				->addRadio('media_type', [
					'label' => 'Media Type',
					'choices' => [
						'image' => 'Image',
						'video' => 'Video',
					],
					'default_value' => 'image',
					'layout' => 'horizontal',
					'return_format' => 'value',
				])
				->addImage('image', [
					'label' => 'Image',
					'instructions' => 'Recommended size: 720px x 480px',
					'return_format' => 'array',
					'preview_size' => 'medium',
				])
					->conditional('media_type', '==', 'image')
				->addField('video', 'clone', [
					'label' => 'Video',
					'clone' => [
						'group_video',
					],
					'display' => 'seamless',
					'prefix_name' => true,
				])
					->conditional('media_type', '==', 'video')
				->addImage('item_icon', [
					'label' => 'Icon',
					'return_format' => 'array',
					'preview_size' => 'medium',
					'required' => 1,
				])
				->addText('item_title', [
					'label' => 'Title',
					'required' => 1,
				])
				->addText('item_subtitle', [
					'label' => 'Subtitle',
					'required' => 1,
				])
				->addWysiwyg('item_text', [
					'label' => 'Text',
					'instructions' => 'Use Enter/Return for line breaks.',
					'media_upload' => 0,
					'toolbar' => 'bold',
					'tabs' => 'visual',
					'delay' => 0,
					'new_lines' => 'br',
				])
			->endRepeater()
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
