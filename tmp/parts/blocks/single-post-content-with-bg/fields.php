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
			->addButtonGroup('margin_size', [
				'label' => 'Select margin size',
				'instructions' => 'Default margin is 32px, large margin is 64px',
				'choices' => [
					'block-mb-default' => 'Default',
					'block-mb-large' => 'Large',
				],
				'default_value' => 'block-mb-default',
				'layout'        => 'horizontal',
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
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
