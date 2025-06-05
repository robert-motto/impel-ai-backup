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
			->addButtonGroup('alignment', [
				'label' => 'Content Alignment',
				'choices' => [
					'center' => 'Center',
					'left' => 'Left',
				],
				'default_value' => 'center',
				'layout' => 'horizontal',
				'return_format' => 'value',
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
				'instructions' => 'Enter the main content text. Use the toolbar for lists and formatting.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => '<p>Ornare purus enim pulvinar at volutpat. Arcu lobortis elementum eu consectetur. Diam proin et senectus condimentum imperdiet vitae nisi. Velit habitasse odio libero.</p>',
			])
			->addField('buttons', 'clone', [
				'clone' => [
					'group_buttons',
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
