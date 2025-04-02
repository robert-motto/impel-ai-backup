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
			->addText('caption', [
				'label' => 'Caption',
				'instructions' => 'Short text above the heading (displayed in uppercase with letter spacing)',
				'default_value' => 'Our Accomplishments',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
				'default_value' => 'We\'ve got the numbers to prove it',
			])
			->addWysiwyg('content', [
				'label' => 'Body Content',
				'instructions' => 'Enter optional description text below the heading.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'all',
				'delay' => 0,
			])
			->addField('buttons', 'clone', [
				'clone' => [
					'group_buttons',
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
					'default_value' => '$7.45B',
				])
				->addText('metric_label', [
					'label' => 'Metric Label',
					'instructions' => 'Enter a descriptive label for the metric.',
					'required' => 1,
					'default_value' => 'Sales and service revenue influenced by Impel\'s AI',
				])
			->endRepeater()
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
