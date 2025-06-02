<?php
	use StoutLogic\AcfBuilder\FieldsBuilder;
	$options = new FieldsBuilder('theme_options');
	$options
		->addTab('Scripts head')
			->addTextarea('head_code')
		->addTab('header')
			->addImage('logo', [
				'instructions' => 'Logo for dark header backgrounds (e.g., initial state on dark sections). This logo will be visible when the header has a dark background.',
				'mime_types' => 'svg,jpg,jpeg,png,gif',
				'return_format' => 'url',
			])
			->addImage('logo_light_mode', [
				'instructions' => 'Logo for light header backgrounds (e.g., when header is scrolled or on light sections). This logo will be visible when the header has a light background.',
				'mime_types' => 'svg,jpg,jpeg,png,gif',
				'return_format' => 'url',
			])
			->addGroup('top_bar', [
				'label' => 'Top Bar Settings',
				'instructions' => 'Settings for the notification bar at the top of the header.',
			])
				->addTrueFalse('show_top_bar', [
					'label' => 'Show Top Bar',
					'default_value' => 0,
					'ui' => 1,
				])
				->addTextarea('top_bar_message', [
					'label' => 'Message',
					'rows' => 2,
					'default_value' => 'Impel and FordDirect Partner to Bring Industry-Leading Conversational AI Solutions to Ford Dealers and Lincoln Retailers',
				])
				->conditional('show_top_bar', '==', '1')
				->addLink('top_bar_link', [
					'label' => 'Link',
				])
				->conditional('show_top_bar', '==', '1')
			->endGroup()
			->addGroup('menu_buttons')
				->addField('menu_buttons', 'clone', [
					'clone' => [
						'group_buttons',
					]
				])
			->endGroup()
			->addGroup('global_dropdown', [
				'label' => 'Global Dropdown Settings',
			])
				->addText('title', [
					'label' => 'Dropdown Title',
					'default_value' => 'Website Location',
				])
				->addTextarea('description', [
					'label' => 'Dropdown Description',
					'default_value' => 'Select your region and language.',
				])
				->addRepeater('links', [
					'label' => 'Dropdown Links',
					'button_label' => 'Add Link',
					'layout' => 'block',
					'min' => 1,
					'default_value' => [
						[
							'link' => [
								'url' => '#',
								'title' => 'North America (EN)',
								'target' => '',
							],
						],
						[
							'link' => [
								'url' => '#',
								'title' => 'Europe (EN)',
								'target' => '',
							],
						],
						[
							'link' => [
								'url' => '#',
								'title' => 'Asia (EN)',
								'target' => '',
							],
						],
					],
				])
					->addLink('link', [
						'label' => 'Link',
						'return_format' => 'array',
					])
				->endRepeater()
			->endGroup()
			->addGroup('login_dropdown', [
				'label' => 'Login Dropdown Settings',
			])
				->addText('title', [
					'label' => 'Dropdown Title',
					'default_value' => 'Log In',
				])
				->addTextarea('description', [
					'label' => 'Dropdown Description',
					'default_value' => 'Access your AI-powered tools and manage your account.',
				])
				->addRepeater('links', [
					'label' => 'Dropdown Links',
					'button_label' => 'Add Link',
					'layout' => 'block',
					'min' => 1,
					'default_value' => [
						[
							'link' => [
								'url' => '#',
								'title' => 'Sales AI Copilot',
								'target' => '',
							],
						],
						[
							'link' => [
								'url' => '#',
								'title' => 'Chat AI',
								'target' => '',
							],
						],
						[
							'link' => [
								'url' => '#',
								'title' => 'Service AI',
								'target' => '',
							],
						],
						[
							'link' => [
								'url' => '#',
								'title' => '360 Manager',
								'target' => '',
							],
						],
					],
				])
					->addLink('link', [
						'label' => 'Link',
						'return_format' => 'array',
					])
					->addTextarea('svg_icon', [
						'label' => 'SVG Icon',
						'instructions' => 'Paste the complete SVG code for the icon. This will be displayed inline before the link text.',
						'rows' => 4,
						'placeholder' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">...</svg>'
					])
				->endRepeater()
			->endGroup()
			->addImage('header_logo')
			->addText('first_dropdown')
			->addPostObject('first_post', [
				'label' => 'Featured post',
			])
			->addText('second_dropdown')
			->addPostObject('second_post', [
				'label' => 'Featured post',
			])
			->addText('third_dropdown')
			->addPostObject('third_post', [
				'label' => 'Featured post',
			])
			->addLink('menu_link')
			->addText('fourth_dropdown')
			->addPostObject('fourth_post', [
				'label' => 'Featured post',
			])
			->addImage('cloud_image')
			->addWysiwyg('cloud_intro', [
				'label' => 'Cloud intro text'
			])
			->addLink('cloud_link', [
				'label' => 'Cloud link',
				'return_format' => 'array',
			])
			->addWysiwyg('cloud_industry', [
				'label' => 'Cloud industry text'
			])
			->addImage('consulting_image')
			->addWysiwyg('consulting_intro', [
				'label' => 'Consulting intro text'
			])
			->addLink('consulting_link', [
				'label' => 'Consulting link',
				'return_format' => 'array',
			])
			->addWysiwyg('consulting_industry', [
				'label' => 'Consulting industry text'
			])
			->addWysiwyg('consulting_solution', [
				'label' => 'Consulting solution text'
			])
			->addRepeater('footer_links', [
				'label' => 'Footer links',
				'button_label' => 'Add Button',
			])
				->addText('text')
				->addLink('link', [
					'label' => 'Link',
					'return_format' => 'array',
				])
			->endRepeater()
			->addGroup('header_button', [
				'label' => ' Get Started Button',
				'instructions' => '',
				'layout' => 'block',
			])
				->addText('text1')
				->addLink('link1', [
					'label' => 'Link',
					'return_format' => 'array',
				])
				->addText('text2')
				->addLink('link2', [
					'label' => 'Link',
					'return_format' => 'array',
				])
			->endGroup()
		->addTab('footer')
			->addField('footer_buttons', 'clone', [
				'label' => 'Additional Footer Buttons',
				'clone' => [
					'group_buttons',
				]
			])
			->addText('copyright', [
				'default_value' => 'All Rights Reserved.',
			])
		->addTab('page 404')
			->addGroup('page_404')
				->addField('page_404', 'clone', [
					'clone' => [
						'group_hero_3',
					]
				])
			->endGroup()
		->addTab('No found')
			->addGroup('no_found')
				->addText('title', [
					'default_value' => 'No results found',
				])
				->addWysiwyg('content' , [
					'default_value' => '<p>Please try a different category or topic.</p>',
				])
			->endGroup()
		->addTab('Global Content')
			->addRepeater('global_logos_slider', [
				'label' => 'Global Logos Slider',
				'instructions' => 'Logos added here can be used as a default by blocks that feature a logos slider. If a block is configured to use global logos, these will be displayed. Recommended size for logos: auto x 42px.',
				'layout' => 'block',
				'button_label' => 'Add Global Logo',
			])
				->addImage('logo', [
					'label' => 'Logo Image',
					'instructions' => 'Recommended size: auto x 42px. Will be displayed in the global logos slider if the block is configured to use it.',
					'return_format' => 'array',
					'preview_size' => 'medium',
					'required' => 1,
				])
			->endRepeater()
		->setLocation('options_page', '==', 'my_globals');
	return $options;
