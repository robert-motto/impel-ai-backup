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
			->addField('tab_buttons', 'clone', [
				'clone' => [
					'group_action_group',
				],
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
			->addSelect('image_display_size', [
				'label' => 'Image Display Size',
				'choices' => [
					'regular' => 'Regular',
					'small'   => 'Small',
				],
				'default_value' => 'regular',
				'return_format' => 'value',
				'ui'            => 1,
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
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
