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
				'label' => 'Content',
				'instructions' => 'Enter the main content text.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => 'Ornare purus enim pulvinar at volutpat. Arcu lobortis elementum eu consectetur. Diam proin et senectus condimentum imperdiet vitae nisi. Velit habitasse odio libero.',
			])
			->addField('buttons_group', 'clone', [
				'clone' => [
					'group_buttons',
				]
			])
			->addRepeater('cards', [
				'label' => 'Carousel Cards',
				'instructions' => 'Add cards to the carousel slider',
				'min' => 1,
				'max' => 10,
				'layout' => 'block',
				'button_label' => 'Add Card',
			])
				->addText('badge_label', [
					'label' => 'Badge Label',
					'instructions' => 'Optional label badge to show above card heading',
					'default_value' => '',
				])
				->addWysiwyg('headline', [
					'label' => 'Card Heading',
					'instructions' => 'Heading for this card',
					'media_upload' => 0,
					'toolbar' => 'basic',
					'tabs' => 'visual',
					'delay' => 0,
					'default_value' => 'Card heading goes here',
				])
				->addWysiwyg('body', [
					'label' => 'Card Content',
					'instructions' => 'Main content for this card',
					'media_upload' => 0,
					'toolbar' => 'full',
					'tabs' => 'all',
					'delay' => 0,
					'default_value' => 'Ornare purus enim pulvinar at volutpat. Arcu lobortis elementum eu consectetur. Diam proin et senectus condimentum imperdiet vitae nisi.',
				])
				->addField('card_buttons_group', 'clone', [
					'clone' => [
						'group_buttons',
					],
					'prefix_name' => 1,
				])
				->addRadio('media_type', [
					'label' => 'Media Type',
					'choices' => [
						'none' => 'None',
						'image' => 'Image',
						'svg' => 'SVG Icon',
					],
					'default_value' => 'image',
					'layout' => 'horizontal',
					'return_format' => 'value',
				])
				->addImage('image', [
					'label' => 'Image',
					'instructions' => 'Upload an image (jpg, png). Recommended size: 720×480px (2x for retina).',
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
					'instructions' => 'Upload an SVG icon. Will be displayed at 64×64px size.',
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
			->endRepeater()
			->addGroup('carousel_settings', [
				'label' => 'Carousel Settings',
				'instructions' => 'Configure the carousel behavior',
				'layout' => 'block',
			])
				->addNumber('autoplay_speed', [
					'label' => 'Autoplay Speed',
					'instructions' => 'Time in milliseconds between slides. Set to 0 to disable autoplay.',
					'default_value' => 3000,
					'min' => 0,
					'max' => 10000,
					'step' => 100,
				])
				->addTrueFalse('pause_on_hover', [
					'label' => 'Pause on Hover',
					'instructions' => 'Pause the carousel when the mouse hovers over it',
					'default_value' => 1,
					'ui' => 1,
				])
				->addNumber('slides_per_view', [
					'label' => 'Slides Per View',
					'instructions' => 'Maximum number of slides to show at once on desktop',
					'default_value' => 3,
					'min' => 1,
					'max' => 5,
					'step' => 1,
				])
				->addTrueFalse('show_scrollbar', [
					'label' => 'Show Scrollbar',
					'instructions' => 'Display a scrollbar below the carousel',
					'default_value' => 1,
					'ui' => 1,
				])
			->endGroup()
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
