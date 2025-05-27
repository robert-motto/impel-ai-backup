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
			->addButtonGroup('mode', [
				'label' => 'Color Mode',
				'choices' => [
					'is-light' => 'Light',
					'is-dark' => 'Dark',
				],
				'default_value' => 'is-dark',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addField('heading', 'clone', [
				'clone' => [
					'group_heading',
				]
			])
			->addField('content', 'clone', [
				'clone' => [
					'group_content',
				]
			])
			->addField('buttons', 'clone', [
				'clone' => [
					'group_buttons',
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
			->addImage('image',[
				'instructions' => 'Sizing: 1200px x auto, try match height of the image to amount of content',
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
