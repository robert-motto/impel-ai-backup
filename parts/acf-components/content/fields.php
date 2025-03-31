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
			->addButtonGroup('content_size', [
				'label' => 'Content font size',
				'instructions' => 'Values displayed in px',
				'choices' => [
					'1' => '20',
					'2' => '17',
					'3' => '15',
					'4' => '13',
				],
				'default_value' => '2',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addWysiwyg('content',[
				'media_upload' => 0,
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
