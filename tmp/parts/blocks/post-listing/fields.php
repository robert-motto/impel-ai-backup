<?php
	use StoutLogic\AcfBuilder\FieldsBuilder;
	$path        = basename(__DIR__);
	$name        = str_replace('-', '_', $path);
	$group_name  = $name . '_group';
	$group_label = str_replace('-', ' ', $path);
	$name        = new FieldsBuilder($name);
	$name
		->addGroup($group_name, [
			'label'        => ucwords($group_label) . ' Block',
			'instructions' => '',
			'layout'       => 'block',
		])
			->addField('section_settings', 'clone', [
				'clone' => [
					'group_section_settings',
				]
			])
			->addButtonGroup('post_type', [
				'label'   => 'What type of posts do you want to display?',
				'choices' => [
					'post'   => 'Blog',
					'custom' => 'Custom',
				],
				'default_value' => 'post',         // Optional: set default value
				'allow_null'    => 0,
				'layout'        => 'horizontal',   // Optional: 'horizontal' or 'vertical'
			])
			->addButtonGroup('hide_empty_cats', [
				'label'   => 'Do you want to hide empty categories / tags?',
				'choices' => [
					'y' => 'Yes',
					'n' => 'No',
				],
				'default_value' => 'y',            // Optional: set default value
				'allow_null'    => 0,
				'layout'        => 'horizontal',   // Optional: 'horizontal' or 'vertical'
			])
			->addField('post_options', 'clone', [
				'clone' => [
					'group_post_options',
				]
			])
			->addField('heading', 'clone', [
				'clone' => [
					'group_heading',
				]
			])
			->addText('search_label', [
				'default_value' => 'Search'
			])
			->addText('categories_label', [
				'default_value' => 'Filter by:'
			])
			->addText('all_filters_label', [
				'default_value' => 'All'
			])
			->addText('tags_label', [
				'default_value' => 'Topic:'
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;


