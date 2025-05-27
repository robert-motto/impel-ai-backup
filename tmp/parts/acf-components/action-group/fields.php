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
			->addButtonGroup('has_buttons', [
				'label' => 'Do you want to display buttons?',
				'choices' => [
					'y' => 'Yes',
					'n' => 'No',
				],
				'default_value' => 'n',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addRepeater('buttons', [
				'button_label' => 'Add button',
				'layout' => 'block',
				'max' => 1,
				'max' => 2
			])
				->conditional('has_buttons', '==', 'y')
				->addField('button', 'clone', [
					'clone' => [
						'group_button',
					]
				])
			->endRepeater()
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
