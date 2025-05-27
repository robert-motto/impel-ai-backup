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
				'default_value' => 'Case Studies',
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
				'default_value' => 'Our clients have transformed their operations with our unified platform. Explore their stories and see how we drive results.',
			])
			->addField('buttons', 'clone', [
				'clone' => [
					'group_buttons',
				]
			])
			->addRepeater('case_studies', [
				'label' => 'Case Studies',
				'instructions' => 'Add case study items',
				'min' => 1,
				'layout' => 'block',
				'button_label' => 'Add Case Study',
			])
				->addWysiwyg('title', [
					'label' => 'Case Study Title',
					'instructions' => 'Enter the title of this case study',
					'media_upload' => 0,
					'toolbar' => 'basic',
					'tabs' => 'visual',
					'delay' => 0,
					'default_value' => 'Medium length section heading goes here',
				])
				->addRadio('media_type', [
					'label' => 'Media Type',
					'instructions' => 'Select the type of media to display',
					'choices' => [
						'image' => 'Image',
						'svg' => 'SVG Icon',
						'video' => 'Video',
					],
					'default_value' => 'image',
					'layout' => 'horizontal',
					'return_format' => 'value',
				])
				->addImage('image', [
					'label' => 'Image',
					'instructions' => 'Upload an image (jpg, png)',
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
				->addImage('svg_icon', [
					'label' => 'SVG Icon',
					'instructions' => 'Upload an SVG icon',
					'return_format' => 'array',
					'preview_size' => 'thumbnail',
					'mime_types' => 'svg',
					'conditional_logic' => [
						[
							[
								'field' => 'media_type',
								'operator' => '==',
								'value' => 'svg',
							]
						]
					]
				])
				->addUrl('video_url', [
					'label' => 'Video URL',
					'instructions' => 'Enter the video URL (YouTube, Vimeo, or direct mp4 link)',
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
				->addImage('company_logo', [
					'label' => 'Company Logo',
					'instructions' => 'Upload the company logo (preferably SVG)',
					'return_format' => 'array',
					'preview_size' => 'medium',
					'mime_types' => 'jpg, png, svg',
				])
				->addText('case_study_url', [
					'label' => 'Case Study URL',
					'instructions' => 'Link to the full case study',
					'default_value' => '#',
				])
				->addText('cta_text', [
					'label' => 'CTA Text',
					'instructions' => 'Text for the call to action button',
					'default_value' => 'Read Case Study',
				])
				->addTrueFalse('has_metric', [
					'label' => 'Add Metric',
					'instructions' => 'Show a metric for this case study',
					'default_value' => 1,
					'ui' => 1,
				])
				->addText('metric_value', [
					'label' => 'Metric Value',
					'instructions' => 'The metric value (e.g., 22%)',
					'default_value' => '22%',
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
					'instructions' => 'Short description of what the metric represents',
					'default_value' => 'increase in showroom appointment set rate',
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
			->addTrueFalse('show_load_more', [
				'label' => 'Show Load More Button',
				'instructions' => 'Enable a button to load more case studies',
				'default_value' => 1,
				'ui' => 1,
			])
			->addText('load_more_text', [
				'label' => 'Load More Text',
				'instructions' => 'Text for the load more button',
				'default_value' => 'Explore more case studies',
				'conditional_logic' => [
					[
						[
							'field' => 'show_load_more',
							'operator' => '==',
							'value' => 1,
						]
					]
				]
			])
			->addNumber('items_per_load', [
				'label' => 'Items Per Load',
				'instructions' => 'Number of items to load each time the load more button is clicked',
				'default_value' => 6,
				'min' => 1,
				'max' => 12,
				'conditional_logic' => [
					[
						[
							'field' => 'show_load_more',
							'operator' => '==',
							'value' => 1,
						]
					]
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
