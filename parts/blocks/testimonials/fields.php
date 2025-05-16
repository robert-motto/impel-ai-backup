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
			->addRepeater('testimonials', [
				'label' => 'Testimonials',
				'instructions' => 'Add testimonial items',
				'min' => 1,
				'layout' => 'block',
				'button_label' => 'Add Testimonial',
			])
				->addText('category_label', [
					'label' => 'Category Label',
					'instructions' => 'Industry or category label (e.g., OEMs, Healthcare)',
					'default_value' => 'OEMs',
				])
				->addWysiwyg('quote', [
					'label' => 'Testimonial Quote',
					'instructions' => 'The testimonial quote text',
					'media_upload' => 0,
					'toolbar' => 'basic',
					'tabs' => 'visual',
					'delay' => 0,
					'default_value' => '"In just three months the AI has influenced $3.2MM in revenue"',
				])
				->addText('person_name', [
					'label' => 'Person Name',
					'instructions' => 'Name of the person giving the testimonial',
					'default_value' => 'Jess McQuillan',
				])
				->addText('company', [
					'label' => 'Company',
					'instructions' => 'Company or organization name',
					'default_value' => 'Central Maine Motors',
				])
				->addRadio('media_type', [
					'label' => 'Media Type',
					'choices' => [
						'video' => 'Video',
						'image' => 'Image',
					],
					'default_value' => 'video',
					'layout' => 'horizontal',
					'return_format' => 'value',
				])
				->addImage('thumbnail', [
					'label' => 'Image',
					'instructions' => 'Upload an image (recommended size: 800x450px)',
									'return_format' => 'array',
									'preview_size' => 'medium',
					'conditional_logic' => [
						[
							[
								'field' => 'media_type',
								'operator' => '==',
								'value' => 'image',
							]
						]
					]
				])
				->addField('video', 'clone', [
					'clone' => [
						'group_video',
					],
					'conditional_logic' => [
						[
							[
								'field' => 'media_type',
								'operator' => '==',
								'value' => 'video',
							]
						]
					]
				])
				->addTrueFalse('has_metric', [
					'label' => 'Add Metric Badge',
					'instructions' => 'Show a metric badge on this testimonial',
					'default_value' => 0,
					'ui' => 1,
				])
				->addRepeater('metrics', [
					'label' => 'Metrics',
					'instructions' => 'Add one or more metrics',
					'min' => 0,
					'max' => 0,
					'layout' => 'block',
					'button_label' => 'Add Metric',
						'conditional_logic' => [
							[
								[
									'field' => 'has_metric',
									'operator' => '==',
									'value' => 1,
								]
							]
						]
				])
					->addText('metric_value', [
						'label' => 'Metric Value',
						'instructions' => 'Enter the metric value (e.g., 75%)',
					])
					->addText('metric_description', [
						'label' => 'Metric Description',
						'instructions' => 'Brief description of what the metric represents',
					])
					->addSelect('metric_icon', [
						'label' => 'Metric Icon',
						'instructions' => 'Select icon to display in the metric badge',
						'choices' => [
							'arrow-up' => 'Arrow Up (Increase)',
							'arrow-down' => 'Arrow Down (Decrease)',
						],
						'default_value' => 'arrow-up',
						'return_format' => 'value',
						'ui' => 1,
					])
				->endRepeater()
			->endRepeater()
			->addField('button', 'clone', [
				'clone' => [
					'group_button',
				]
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
