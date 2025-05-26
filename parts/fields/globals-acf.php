<?php
	use StoutLogic\AcfBuilder\FieldsBuilder;
	$options = new FieldsBuilder('theme_options');
	$options
		->addTab('Scripts head')
			->addTextarea('head_code')
		->addTab('header')
			->addImage('logo', [
				'insctructions' => 'Logo for dark mode, in svg format',
				'mime_types' => 'svg',
				'return_format' => 'url',
			])
			->addImage('logo_white', [
				'insctructions' => 'Logo for light mode, in svg format',
				'mime_types' => 'svg',
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
				->endRepeater()
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
		->setLocation('options_page', '==', 'my_globals');
	return $options;
