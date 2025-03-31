<?php
	use StoutLogic\AcfBuilder\FieldsBuilder;
	$path = basename(__DIR__);
	$name = str_replace('-', '_', $path);
	$group_name = $name . '_group';
	$group_label = str_replace('-', ' ', $path);
	$name = new FieldsBuilder($name);
	$name
		->addGroup($group_name, [
			'label' => ucwords($group_label) . ' Component',
			'instructions' => '',
			'layout' => 'block',
		])
			->addButtonGroup('has_description', [
				'label' => 'Do you want to add a description to a post?',
				'choices' => [
					'y' => 'Yes',
					'n' => 'No',
				],
				'default_value' => 'n',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addButtonGroup('has_reading_time', [
				'label' => 'Do you want to add a reading time to a post?',
				'choices' => [
					'y' => 'Yes',
					'n' => 'No',
				],
				'default_value' => 'n',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
