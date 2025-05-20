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
			->addGroup('menu_buttons')
				->addField('menu_buttons', 'clone', [
					'clone' => [
						'group_buttons',
					]
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
		->setLocation('options_page', '==', 'my_globals');
	return $options;
