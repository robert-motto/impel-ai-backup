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
			->addField('heading', 'clone', [
				'clone' => [
					'group_heading',
				]
			])
			->addField('content', 'clone', [
				'clone' => [
					'group_content',
				]
			])
			->addField('buttons', 'clone', [
				'clone' => [
					'group_buttons',
				]
			])
			->addButtonGroup('post_type', [
				'label' => 'Post type',
				'choices' => [
					'post' => 'Blog',
					'custom' => 'Custom',
				],
				'default_value' => 'post',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addButtonGroup('type_of_display', [
				'label' => 'Do you want to display custom posts or last news posts?',
				'choices' => [
					'newest' => 'Newest',
					'custom' => 'Custom',
				],
				'default_value' => 'newest',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addField('post_options', 'clone', [
				'clone' => [
					'group_post_options',
				]
			])
			->addRelationship('selected_posts', [
				'label' => 'Posts',
				'instructions' => 'Remember to select posts from the same post type',
				'conditional_logic' => [
					[
						[
							'field' => 'display_options',
							'operator' => '==',
							'value' => 'custom',
						],
					],
				],
				'post_type' => ['post', 'custom'],
				'taxonomy' => [],
				'filters' => [
					0 => 'search',
					1 => 'post_type',
					2 => 'taxonomy',
				],
				'min' => '0',
				'max' => '3',
				'return_format' => 'id',
			])
				->conditional('type_of_display', '==', 'custom')
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
