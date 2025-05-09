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
			->addText('id', [
				'label'        => 'ID',
				'instructions' => 'This will be the ID of the section. It will be used for the anchor link. Must be unique.',
			])
			->addButtonGroup('mode', [
				'label'   => 'Color Mode',
				'choices' => [
					'is-light' => 'Light',
					'is-dark'  => 'Dark',
				],
				'default_value' => 'is-light',
				'layout'        => 'horizontal',
				'return_format' => 'value',
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
