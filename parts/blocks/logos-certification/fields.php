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
				'default_value' => 'PARTNERS & CERTIFICATIONS',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
				'default_value' => 'Trusted by Industry Leaders',
			])
			->addWysiwyg('content', [
				'label' => 'Body Content',
				'instructions' => 'Enter the main content text. Use the toolbar for lists and formatting.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => 'We partner with top industry companies and organizations to deliver the best solutions for our clients.',
			])
			->addField('buttons', 'clone', [
				'clone' => [
					'group_buttons',
				]
			])
			->addButtonGroup('layout_variant', [
				'label' => 'Layout Variant',
				'choices' => [
					'compact' => 'Compact',
					'extended' => 'Extended',
				],
				'default_value' => 'compact',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addButtonGroup('display_mode', [
				'label' => 'Display Mode',
				'choices' => [
					'row' => 'Inline Row',
					'carousel' => 'Auto-Play Carousel',
				],
				'default_value' => 'row',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addRepeater('logos', [
				'label' => 'Logos/Badges',
				'instructions' => 'Add logos or certification badges',
				'layout' => 'block',
				'min' => 1,
				'max' => 0,
				'button_label' => 'Add Logo',
			])
				->addImage('logo', [
					'label' => 'Logo Image',
					'instructions' => 'Recommended size: 180px x 100px',
					'return_format' => 'array',
					'preview_size' => 'medium',
					'required' => 1,
				])
				->addText('title', [
					'label' => 'Logo Title',
					'instructions' => 'Enter a title for this logo (used for alt text and hover)',
					'default_value' => '',
				])
				->addText('description', [
					'label' => 'Description',
					'instructions' => 'Short description to display under the logo (shown in extended view only)',
					'default_value' => '',
				])
				->addUrl('link', [
					'label' => 'Link URL',
					'instructions' => 'Optional: Add a link to an external site (leave empty for non-clickable logos)',
					'default_value' => '',
				])
			->endRepeater()
			->addGroup('carousel_settings', [
				'label' => 'Carousel Settings',
				'instructions' => 'Configure the carousel behavior',
				'layout' => 'block',
				'conditional_logic' => [
					[
						[
							'field' => 'display_mode',
							'operator' => '==',
							'value' => 'carousel',
						],
					],
				],
			])
				->addNumber('autoplay_speed', [
					'label' => 'Autoplay Speed',
					'instructions' => 'Time in milliseconds between slide transitions (1000 = 1 second)',
					'default_value' => 3000,
					'min' => 1000,
					'max' => 10000,
					'step' => 500,
				])
				->addTrueFalse('pause_on_hover', [
					'label' => 'Pause on Hover',
					'instructions' => 'Pause the carousel when user hovers over it',
					'default_value' => 1,
					'ui' => 1,
				])
				->addNumber('slides_per_view', [
					'label' => 'Slides Per View',
					'instructions' => 'Number of logos to show at once (will be responsive)',
					'default_value' => 5,
					'min' => 1,
					'max' => 10,
					'step' => 1,
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
