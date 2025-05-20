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
			->addText('caption', [
				'label' => 'Caption',
				'instructions' => 'Short text above the heading',
				'default_value' => 'Integrations',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
				'default_value' => 'Connect Seamlessly With Your Existing Systems',
			])
			->addWysiwyg('content', [
				'label' => 'Body Content',
				'instructions' => 'Enter the main content text. Use the toolbar for lists and formatting.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => '<p>Impel\'s solutions integrate with your existing tech stack, allowing you to leverage your current investments while enhancing capabilities through our AI-powered platform.</p>',
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
			->addTrueFalse('show_divider', [
				'label' => 'Show Divider Line',
				'instructions' => 'Display a divider line below the content',
				'default_value' => 0,
				'ui' => 1,
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
