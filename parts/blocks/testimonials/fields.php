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
				'instructions' => 'Short text above the heading',
				'default_value' => 'Testimonials',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
				'default_value' => 'Real Results from Real Clients',
			])
			->addWysiwyg('content', [
				'label' => 'Body Content',
				'instructions' => 'Enter the main content text.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => 'Our clients have transformed their operations with Impel.ai\'s unified platform. Hear their stories and see how we drive results.',
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
						'image' => 'Image Only',
					],
					'default_value' => 'video',
					'layout' => 'horizontal',
					'return_format' => 'value',
				])
				->addImage('thumbnail', [
					'label' => 'Thumbnail Image',
					'instructions' => 'Upload a thumbnail image (recommended size: 800x450px)',
					'return_format' => 'array',
					'preview_size' => 'medium',
				])
				->addUrl('video_url', [
					'label' => 'Video URL',
					'instructions' => 'Enter the video URL (YouTube, Vimeo, or direct mp4 link)',
					'default_value' => '',
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
				->addText('metric_value', [
					'label' => 'Metric Value',
					'instructions' => 'Enter the metric value (e.g., 75%)',
					'default_value' => '75%',
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
				->addText('metric_description', [
					'label' => 'Metric Description',
					'instructions' => 'Brief description of what the metric represents',
					'default_value' => 'Boosts conversion rates through personalized interactions.',
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
			->endRepeater()
			->addField('buttons', 'clone', [
				'clone' => [
					'group_buttons',
				]
			])
			->addTrueFalse('has_background', [
				'label' => 'Use Background Color',
				'instructions' => 'Add background color to the section',
				'default_value' => 1,
				'ui' => 1,
			])
			->addSelect('background_color', [
				'label' => 'Background Color',
				'instructions' => 'Select background color',
				'choices' => [
					'light' => 'Light (Gray)',
					'white' => 'White',
					'dark' => 'Dark',
				],
				'default_value' => 'light',
				'return_format' => 'value',
				'multiple' => 0,
				'ui' => 1,
				'conditional_logic' => [
					[
						[
							'field' => 'has_background',
							'operator' => '==',
							'value' => 1,
						]
					]
				]
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
