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
			->addButtonGroup('has_subheading', [
				'label' => 'Do you want to add a subheading?',
				'choices' => [
					'y' => 'Yes',
					'n' => 'No',
				],
				'default_value' => 'n',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addButtonGroup('subheading_size', [
				'label' => 'Subheading font size',
				'instructions' => 'Values displayed in px',
				'choices' => [
					'1' => '36',
					'2' => '28',
					'3' => '24',
					'4' => '20',
				],
				'default_value' => '4',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
				->conditional('has_subheading', '==', 'y')
			->addWysiwyg('subheading', [
				'media_upload' => 0,
			])
				->conditional('has_subheading', '==', 'y')
			->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
