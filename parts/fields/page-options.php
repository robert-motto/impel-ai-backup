<?php
	use StoutLogic\AcfBuilder\FieldsBuilder;
	$options = new FieldsBuilder('page_options');
	$options
		->addButtonGroup('menu_type', [
			'label' => 'Submenu type',
			'choices' => [
				'is-dark' => 'Light',
				'is-light' => 'Dark',
			],
			'default_value' => 'is-dark',
			'layout' => 'horizontal',
			'return_format' => 'value',
		])
		->setLocation('post_type', '==', 'page')
			->or('post_type', '==', 'post')
			->or('post_type', '==', 'custom');
	return $options;
