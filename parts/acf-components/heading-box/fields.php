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
			->addSelect('alignment', [
				'label' => 'Alignment',
				'choices' => [
					'central' => 'Central',
					'left' => 'Left',
				],
				'default_value' => 'central',
				'return_format' => 'value',
				'ui' => 1,
			])
			->addText('caption', [
				'label' => 'Caption',
			])
			->addText('heading', [
				'label' => 'Heading',
			])
			->addSelect('heading_size', [
				'label' => 'Heading size',
				'choices' => [
					'small' => 'Small',
					'regular' => 'Regular',
					'large' => 'Large',
				],
				'default_value' => 'regular',
				'return_format' => 'value',
				'ui' => 1,
			])
			->addTextarea('subheading', [
				'label' => 'Subheading',
				'rows' => '4',
				'new_lines' => 'br',
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
