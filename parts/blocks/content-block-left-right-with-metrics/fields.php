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
			->addText('caption', [
				'label' => 'Caption',
				'instructions' => 'Short text above the heading',
				'default_value' => 'Key Metrics',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
				'default_value' => 'Our Impact in Numbers',
			])
			->addWysiwyg('content', [
				'label' => 'Body Content',
				'instructions' => 'Enter the main content text. Use the toolbar for lists and formatting.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => '<p>Our solutions have driven significant improvements across various metrics, showcasing the effectiveness of our approach.</p>',
			])
			->addRepeater('metrics', [
				'label' => 'Key Metrics',
				'instructions' => 'Add up to 4 key metrics.',
				'layout' => 'block',
				'button_label' => 'Add Metric',
				'min' => 4,
				'max' => 4,
			])
				->addText('metric_value', [
					'label' => 'Metric Value',
					'instructions' => 'Enter the value of the metric.',
					'required' => 1,
					'default_value' => '100%',
				])
				->addText('metric_label', [
					'label' => 'Metric Label',
					'instructions' => 'Enter a short label for the metric.',
					'required' => 1,
					'default_value' => 'Increase in Efficiency',
				])
			->endRepeater()
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
