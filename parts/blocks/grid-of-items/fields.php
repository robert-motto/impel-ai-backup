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
			->addRadio('display_mode', [
				'label' => 'Display Mode',
				'instructions' => 'Select how to display the items.',
				'choices' => [
					'grid' => 'Grid',
					'carousel' => 'Carousel'
				],
				'default_value' => 'grid',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addRadio('item_style', [
				'label' => 'Grid Card Style',
				'instructions' => 'Select the visual style for each grid card',
				'choices' => [
					'with-icons' => 'With Icons',
					'with-images' => 'With Images',
					'portfolio' => 'Portfolio'
				],
				'default_value' => 'with-icons',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addNumber('carousel_slides_per_view_desktop', [
				'label' => 'Slides Per View (Desktop)',
				'instructions' => 'Number of items visible at once on desktop (e.g., 3.2 for partial next slide).',
				'default_value' => 3.2,
				'min' => 1,
				'max' => 5,
				'step' => 0.1,
				'conditional_logic' => [
					[
						[
							'field' => 'display_mode',
							'operator' => '==',
							'value' => 'carousel',
						]
					]
				]
			])
			->addTrueFalse('carousel_autoplay', [
				'label' => 'Autoplay Carousel',
				'default_value' => 0,
				'ui' => 1,
				'conditional_logic' => [
					[
						[
							'field' => 'display_mode',
							'operator' => '==',
							'value' => 'carousel',
						]
					]
				]
			])
			->addNumber('carousel_autoplay_speed', [
				'label' => 'Autoplay Speed (ms)',
				'instructions' => 'Delay between transitions (in milliseconds).',
				'default_value' => 3000,
				'min' => 1000,
				'conditional_logic' => [
					[
						[
							'field' => 'display_mode',
							'operator' => '==',
							'value' => 'carousel',
						],
						[
							'field' => 'carousel_autoplay',
							'operator' => '==',
							'value' => '1',
						]
					]
				]
			])
			->addTrueFalse('carousel_pause_on_hover', [
				'label' => 'Pause Autoplay on Hover',
				'default_value' => 1,
				'ui' => 1,
				'conditional_logic' => [
					[
						[
							'field' => 'display_mode',
							'operator' => '==',
							'value' => 'carousel',
						],
						[
							'field' => 'carousel_autoplay',
							'operator' => '==',
							'value' => '1',
						]
					]
				]
			])
			->addTrueFalse('carousel_show_navigation', [
				'label' => 'Show Navigation Arrows',
				'default_value' => 1,
				'ui' => 1,
				'conditional_logic' => [
					[
						[
							'field' => 'display_mode',
							'operator' => '==',
							'value' => 'carousel',
						]
					]
				]
			])
			->addTrueFalse('carousel_show_progressbar', [
				'label' => 'Show Progress Bar',
				'default_value' => 1,
				'ui' => 1,
				'conditional_logic' => [
					[
						[
							'field' => 'display_mode',
							'operator' => '==',
							'value' => 'carousel',
						]
					]
				]
			])
			->addRadio('columns_count', [
				'label' => 'Number of Columns',
				'instructions' => 'Select number of columns to display on desktop',
				'choices' => [
					'2' => '2 Columns',
					'3' => '3 Columns'
				],
				'default_value' => '3',
				'layout' => 'horizontal',
				'return_format' => 'value',
				'conditional_logic' => [
					[
						[
							'field' => 'display_mode',
							'operator' => '==',
							'value' => 'grid',
						]
					]
				]
			])
			->addField('button_group', 'clone', [
				'label' => '"See More" Button',
				'clone' => [
					'group_button',
				],
				'conditional_logic' => [
					[
						[
							'field' => 'display_mode',
							'operator' => '==',
							'value' => 'carousel',
						]
					]
				],
				'default_value' => [
					'type' => 'link',
					'size' => 'regular',
					'has_icon' => 'y',
					'icon_position' => 'right',
					'button' => [
						'title' => 'See More Success Stories',
						'url' => '#',
						'target' => '',
					],
				]
			])
			->addRepeater('grid_items', [
				'label' => 'Grid Cards',
				'instructions' => 'Add cards to display in the grid',
				'min' => 1,
				'layout' => 'block',
				'button_label' => 'Add Card',
			])
	->addText('item_heading', [
					'label' => 'Card Heading',
					'instructions' => 'Heading for this grid card',
	'maxlength' => 124,
				])
	->addTextarea('item_content', [
					'label' => 'Card Content',
					'instructions' => 'Main content for this grid card',
	'rows' => 8,
	'maxlength' => 228,
				])
	->addLink('item_link', [
		'label' => 'Card Link',
		'instructions' => 'Link for this grid card',
		'return_format' => 'array',
				])
				->addImage('image', [
					'label' => 'Image',
					'instructions' => 'Upload an image (jpg, png)',
					'return_format' => 'array',
					'preview_size' => 'medium',
					'conditional_logic' => [
						[
							[
				'field' => 'item_style',
								'operator' => '==',
				'value' => 'with-images',
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
				'field' => 'item_style',
								'operator' => '==',
				'value' => 'with-icons',
							]
						],
						[
							[
				'field' => 'item_style',
								'operator' => '==',
				'value' => 'portfolio',
							]
						]
					]
				])
				->addTrueFalse('item_show_icon', [
					'label' => 'Show Icon',
					'instructions' => 'Show the svg icon',
					'default_value' => 1,
					'ui' => 1,
				])
				->addTrueFalse('item_has_metric_box', [
					'label' => 'Add Metric Box?',
					'instructions' => 'Display a metric box at the bottom of the card (carousel mode only).',
					'default_value' => 0,
					'ui' => 1,
				])
				->addText('item_metric_value', [
					'label' => 'Metric Value',
					'instructions' => 'E.g., 22%',
					'conditional_logic' => [
						[
							[
								'field' => 'item_has_metric_box',
								'operator' => '==',
								'value' => '1',
							]
						]
					]
				])
				->addTextarea('item_metric_description', [
					'label' => 'Metric Description',
					'instructions' => 'E.g., Increase in showroom appointment set rate',
					'rows' => 2,
					'conditional_logic' => [
						[
							[
								'field' => 'item_has_metric_box',
								'operator' => '==',
								'value' => '1',
							]
						]
					]
				])
				->addSelect('item_metric_icon', [
					'label' => 'Metric Icon',
					'choices' => [
						'none' => 'None',
						'arrow-up-right' => 'Arrow Up Right',
						'arrow-down-right' => 'Arrow Down Right',
					],
					'default_value' => 'arrow-up-right',
					'conditional_logic' => [
						[
							[
								'field' => 'item_has_metric_box',
								'operator' => '==',
								'value' => '1',
							]
						]
					]
				])
			->endRepeater()
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
