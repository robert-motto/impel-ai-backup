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
				'instructions' => 'Choose up to 3 posts to display',
				'post_type' => ['post'],
				'taxonomy' => [],
				'filters' => [
					0 => 'search',
					1 => 'post_type',
					2 => 'taxonomy',
				],
				'min' => 0,
				'max' => 3,
				'return_format' => 'id',
			])
				->conditional('type_of_display', '==', 'custom')
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
