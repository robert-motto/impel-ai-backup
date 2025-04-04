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
				'instructions' => 'Optional short text above the heading',
				'default_value' => 'Enterprise-grade security & Compliance',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
				'default_value' => 'Enterprise-grade security & Compliance',
			])
			->addWysiwyg('content', [
				'label' => 'Body Content',
				'instructions' => 'Enter the main content text.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => 'Stay ahead of evolving security challenges with AI-driven safeguards designed to protect your data and ensure regulatory compliance. Access our knowledge bank to minimize risks, prevent AI hallucinations, and explore best practices for jailbreak prevention.',
			])
			->addField('buttons', 'clone', [
				'clone' => [
					'group_buttons',
				]
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
