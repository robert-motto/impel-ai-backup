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
				'default_value' => 'TAGLINE',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
				'default_value' => 'Before & After',
			])
			->addWysiwyg('content', [
				'label' => 'Body Content',
				'instructions' => 'Enter the main content text. Use the toolbar for lists and formatting.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => 'Ornare purus enim pulvinar at volutpat. Arcu lobortis elementum eu consectetur. Diam proin et senectus condimentum imperdiet vitae nisi. Velit habitasse odio libero.',
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
