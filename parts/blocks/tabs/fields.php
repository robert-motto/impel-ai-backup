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
				'default_value' => 'Tagline',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
				'default_value' => 'Short heading goes here',
			])
			->addWysiwyg('content', [
				'label' => 'Body Content',
				'instructions' => 'Enter the main content text.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => 'Ornare purus enim pulvinar at volutpat. Arcu lobortis elementum eu consectetur. Diam proin et senectus condimentum imperdiet vitae nisi. Velit habitasse odio libero.',
			])
			->addField('buttons', 'clone', [
				'clone' => [
					'group_buttons',
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
					'default_value' => 'Tab',
				])
				->addWysiwyg('tab_heading', [
					'label' => 'Tab Heading',
					'instructions' => 'Main heading for this tab content',
					'media_upload' => 0,
					'toolbar' => 'basic',
					'tabs' => 'visual',
					'delay' => 0,
					'default_value' => 'Medium length section heading goes here',
				])
				->addWysiwyg('tab_content', [
					'label' => 'Tab Content',
					'instructions' => 'Main content for this tab',
					'media_upload' => 0,
					'toolbar' => 'full',
					'tabs' => 'all',
					'delay' => 0,
					'default_value' => 'Ornare purus enim pulvinar at volutpat. Arcu lobortis elementum eu consectetur. Diam proin et senectus condimentum imperdiet vitae nisi. Velit habitasse odio libero.',
				])
				->addField('tab_buttons', 'clone', [
					'clone' => [
						'group_buttons',
					],
					'prefix_name' => 1,
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
				->addText('media_description', [
					'label' => 'Media Description',
					'instructions' => 'Optional description for the image or video',
					'default_value' => 'Description of the asset',
				])
				->addTrueFalse('show_key_metric', [
					'label' => 'Show Key Metric',
					'instructions' => 'Display a key metric with logo',
					'default_value' => 0,
					'ui' => 1,
				])
				->addImage('metric_logo', [
					'label' => 'Metric Logo',
					'instructions' => 'Logo to display with the metric (optional)',
					'return_format' => 'array',
					'preview_size' => 'thumbnail',
				])
					->conditional('show_key_metric', '==', 1)
				->addText('metric_text', [
					'label' => 'Metric Text',
					'instructions' => 'Text describing the metric',
					'default_value' => '22% increase in showroom appointment set rate',
				])
					->conditional('show_key_metric', '==', 1)
				->addText('badge_label', [
					'label' => 'Badge Label',
					'instructions' => 'Optional label badge to show above tab heading',
					'default_value' => 'Label',
				])
			->endRepeater()
			->addTrueFalse('has_background', [
				'label' => 'Use Background Color',
				'instructions' => 'Add background color to the section',
				'default_value' => 0,
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
			])
				->conditional('has_background', '==', 1)
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
