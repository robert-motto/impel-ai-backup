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
			->addButtonGroup('size', [
				'label' => 'Select button size',
				'choices' => [
					'default' => 'Default',
					'large' => 'Large',
					'extra-large' => 'Extra Large',
				],
				'default_value' => 'default',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addButtonGroup('type', [
				'label' => 'Select button type',
				'choices' => [
					'primary' => 'Primary',
					'secondary' => 'Secondary',
					'link' => 'Link',
				],
				'default_value' => 'primary',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addLink('button')
			->addButtonGroup('has_icon', [
				'label' => 'Do you want to display the icon?',
				'choices' => [
					'y' => 'Yes',
					'n' => 'No',
				],
				'default_value' => 'n',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addButtonGroup('icon_position', [
				'label' => 'Select icon position',
				'choices' => [
					'left' => 'Left',
					'right' => 'Right',
				],
				'default_value' => 'right',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
				->conditional('has_icon', '==', 'y')
			->addImage('icon', [
				'instructions' => 'Icon in svg format, by default it will be an arrow',
				'mime_types' => 'svg',
			])
				->conditional('has_icon', '==', 'y')
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
