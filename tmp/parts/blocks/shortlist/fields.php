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
			])
			->addField('buttons', 'clone', [
				'label' => 'Header Button',
				'clone' => [
					'group_buttons',
				]
			])
			->addButtonGroup('type_of_display', [
				'label' => 'Which posts to display?',
				'choices' => [
					'newest' => '3 Newest Posts',
					'custom' => 'Choose Manually',
				],
				'default_value' => 'newest',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addRelationship('selected_posts', [
				'label' => 'Select Posts',
				'instructions' => 'Choose posts to display',
				'post_type' => ['post'],
				'taxonomy' => [],
				'filters' => [
					0 => 'search',
					1 => 'post_type',
					2 => 'taxonomy',
				],
				'min' => 0,
				'max' => 10,
				'return_format' => 'id',
			])
				->conditional('type_of_display', '==', 'custom')
			->addTrueFalse('show_images', [
				'label' => 'Show Images',
				'instructions' => 'Toggle to show or hide images in the cards',
				'default_value' => 1,
				'ui' => 1,
				'ui_on_text' => 'Show',
				'ui_off_text' => 'Hide',
			])
			->addField('button_settings', 'clone', [
				'label' => 'Button Settings',
				'clone' => [
					'group_button',
				]
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
