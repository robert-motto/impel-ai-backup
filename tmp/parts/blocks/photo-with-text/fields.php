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
			->addButtonGroup('image_position', [
				'label' => 'Select image position',
				'choices' => [
					'l-row--reverse' => 'Left',
					'l-row--default' => 'Right',
				],
				'default_value' => 'l-row--default',
				'layout'        => 'horizontal',
				'return_format' => 'value',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
				'default_value' => 'Lorem Ipsum Dolor Sit',
			])
			->addWysiwyg('subheading', [
				'label' => 'Subheading',
				'instructions' => 'Enter the subheading text.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
			])
			->addWysiwyg('content', [
				'label' => 'Content',
				'instructions' => 'Enter the main content text.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => '<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>',
			])
			->addField('buttons', 'clone', [
				'clone' => [
					'group_buttons',
				]
			])
			->addImage('image',[
				'instructions' => 'Sizing: 1200px x auto, try match height of the image to amount of content',
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
