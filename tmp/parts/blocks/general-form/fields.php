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
			->addText('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the heading for the form section.',
				'default_value' => 'Request a Personalized Demo',
			])
			->addWysiwyg('content', [
				'label' => 'Content',
				'instructions' => 'Enter descriptive text about the form.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => 'Discover how Impel\'s industry-leading Automotive AI Platform can enhance customer engagement, increase showroom appointments, and drive revenue growth. Get in touch with our team to see how AI-powered automation delivers a 25:1 ROI for dealers, OEMs, and marketplaces like yours.',
			])
			->addNumber('gravity_form_id', [
				'label' => 'Gravity Form ID',
				'instructions' => 'Enter the ID of the Gravity Form to display.',
				'required' => 1,
				'min' => 1,
				'default_value' => 1,
			])
			->addTrueFalse('add_background', [
				'label' => 'Add Background',
				'instructions' => 'Enable to add a background color to the form section.',
				'default_value' => 1,
				'ui' => 1,
			])
			->addSelect('background_color', [
				'label' => 'Background Color',
				'instructions' => 'Select the background color for the form section.',
				'choices' => [
					'light' => 'Light (Gray)',
					'white' => 'White',
					'dark' => 'Dark',
				],
				'default_value' => 'light',
				'return_format' => 'value',
				'conditional_logic' => [
					[
						[
							'field' => 'add_background',
							'operator' => '==',
							'value' => 1,
						],
					],
				],
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
