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
			->addField('heading', 'clone', [
				'clone' => [
					'group_heading_box',
				]
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
				'instructions' => 'Recommended size: 1040px x 580px',
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
			])
				->conditional('media_type', '==', 'video')
			->addText('media_caption', [
				'label' => 'Media Caption',
				'instructions' => 'Add an optional caption for the media (displayed at the top right corner of the image or video)',
				'default_value' => '',
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
