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
			->addField('section_settings', 'clone', [
				'clone' => [
					'group_section_settings',
				]
			])
			->addButtonGroup('mode_variant', [
				'label'   => 'Color Mode Variant',
				'choices' => [
					'primary' => 'Primary',
					'secondary'  => 'Secondary',
				],
				'default_value' => 'primary',
				'layout'        => 'horizontal',
				'return_format' => 'value',
			])
			->addButtonGroup('layout_variant', [
				'label' => 'Layout Variant',
				'choices' => [
					'text-left' => 'Text Left',
					'text-right' => 'Text Right',
				],
				'default_value' => 'text-left',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addField('heading', 'clone', [
				'clone' => [
					'group_heading_box',
				]
			])
			->addRepeater('metrics', [
				'label' => 'Key Metrics',
				'instructions' => 'Add up to 4 key metrics.',
				'layout' => 'block',
				'button_label' => 'Add Metric',
				'min' => 4,
				'max' => 4,
			])
				->addImage('metric_icon', [
					'label' => 'Metric Icon',
					'return_format' => 'array',
					'preview_size' => 'medium',
					'required' => 1,
				])
				->addText('metric_value', [
					'label' => 'Metric Value',
					'instructions' => 'Enter the value of the metric.',
					'maxlength' => '8',
					'required' => 1,
				])
				->addText('metric_label', [
					'label' => 'Metric Label',
					'instructions' => 'Enter a short label for the metric.',
					'maxlength' => '73',
					'required' => 1,
				])
			->endRepeater()
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
