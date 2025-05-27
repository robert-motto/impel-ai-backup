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
				'default_value' => '',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
				'default_value' => 'The industry\'s Only AI Operating System',
			])
			->addWysiwyg('content', [
				'label' => 'Body Content',
				'instructions' => 'Enter the main content text.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => 'Innovation that shifts gears to propel you ahead. Impel.ai seamlessly integrates with your systems, unifying touchpoints, eliminating friction, and driving powerful results. The road ahead is changing—lead the way.',
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
			->addText('media_disclaimer', [
				'label' => 'Media Disclaimer',
				'instructions' => 'Optional description for the image or video (appears below media)',
				'default_value' => '',
			])
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
			->addTrueFalse('has_border_radius', [
				'label' => 'Use Border Radius',
				'instructions' => 'Add rounded corners to the section',
				'default_value' => 1,
				'ui' => 1,
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
