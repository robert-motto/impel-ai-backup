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
			->addButtonGroup('pt', [
				'label'   => 'Padding Top',
				'instructions' => 'Values displayed in px',
				'choices' => [
					'l-pt-4xl'  => '120',
					'l-pt-3xl'  => '96',
					'l-pt-2xl'  => '88',
					'l-pt-xl'   => '80',
					'l-pt-lg'   => '64',
					'l-pt-md'   => '48',
					'l-pt-s'    => '40',
					'l-pt-xs'   => '32',
					'l-pt-2xs'  => '16',
					'l-pt-3xs'  => '8',
					'l-pt-none' => 'None',
				],
				'default_value' => 'l-pt-lg',
				'layout'        => 'horizontal',
				'return_format' => 'value',
			])
			->addButtonGroup('pb', [
				'label'   => 'Padding Bottom',
				'instructions' => 'Values displayed in px',
				'choices' => [
					'l-pb-4xl'  => '120',
					'l-pb-3xl'  => '96',
					'l-pb-2xl'  => '88',
					'l-pb-xl'   => '80',
					'l-pb-lg'   => '64',
					'l-pb-md'   => '48',
					'l-pb-s'    => '40',
					'l-pb-xs'   => '32',
					'l-pb-2xs'  => '16',
					'l-pb-3xs'  => '8',
					'l-pb-none' => 'None',
				],
				'default_value' => 'l-pb-lg',
				'layout'        => 'horizontal',
				'return_format' => 'value',
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
