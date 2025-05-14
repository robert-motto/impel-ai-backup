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
			->addField('heading', 'clone', [
				'clone' => [
					'group_heading_box',
				]
			])
			->addRepeater('metrics', [
				'label' => 'Metrics',
				'instructions' => 'Add metrics to display in a grid layout.',
				'layout' => 'block',
				'button_label' => 'Add Metric',
				'min' => 1,
				'max' => 8,
			])
				->addText('metric_value', [
					'label' => 'Metric Value',
					'instructions' => 'Enter the numeric value (can include currency symbols, e.g., $7.45B).',
					'required' => 1,
				])
				->addText('metric_label', [
					'label' => 'Metric Label',
					'instructions' => 'Enter a descriptive label for the metric.',
					'required' => 1,
				])
			->endRepeater()
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
