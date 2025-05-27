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
			->addRepeater('tabs', [
				'label' => 'Tabs',
				'instructions' => 'Add between 2 and 6 tabs.',
				'min' => 2,
				'max' => 6,
				'layout' => 'block',
				'button_label' => 'Add Tab',
			])
				->addText('tab_title', [
					'label' => 'Tab Title',
					'instructions' => 'Short title for the tab (visible in tab navigation)',
					'required' => 1,
				])
				->addTextarea('tab_caption', [
					'label' => 'Tab Caption',
					'instructions' => 'Optional caption text to display above tab heading',
					'maxlength' => '70',
					'rows' => '2',
					'new_lines' => 'br',
				])
				->addTextarea('tab_heading', [
					'label' => 'Tab Heading',
					'instructions' => 'Main heading for this tab content',
					'maxlength' => '123',
					'rows' => '2',
					'new_lines' => 'br',
				])
				->addTextarea('tab_content', [
					'label' => 'Tab Content',
					'instructions' => 'Main content for this tab',
					'maxlength' => '429',
					'rows' => '8',
					'new_lines' => 'br',
				])
				->addField('tab_buttons', 'clone', [
					'clone' => [
						'group_action_group',
					],
				])
				->addRadio('media_type', [
					'label' => 'Media Type',
					'choices' => [
						'image' => 'Image',
						'video' => 'Video',
					],
					'default_value' => 'image',
					'layout' => 'horizontal',
					'return_format' => 'value',
				])
				->addImage('image', [
					'label' => 'Image',
					'instructions' => 'Recommended size: 720px x 480px',
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
				->addGroup('video_group', [
					'label' => 'Video',
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
					->addField('video', 'clone', [
						'clone' => [
							'group_video',
						],
						'display' => 'seamless',
						'prefix_name' => false,
					])
				->endGroup()
				->addTrueFalse('show_key_metric', [
					'label' => 'Show Key Metric',
					'instructions' => 'Display a key metric with logo',
					'default_value' => 1,
					'ui' => 1,
				])
				->addImage('metric_logo', [
					'label' => 'Metric Logo',
					'instructions' => 'Logo to display with the metric',
					'return_format' => 'array',
					'preview_size' => 'thumbnail',
				])
					->conditional('show_key_metric', '==', 1)
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
					->conditional('show_key_metric', '==', 1)
				->addText('metric_text', [
					'label' => 'Metric Text',
					'instructions' => 'Text describing the metric',
				])
					->conditional('show_key_metric', '==', 1)
			->endRepeater()
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
