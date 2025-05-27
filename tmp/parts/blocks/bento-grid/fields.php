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
			->addRepeater('segments', [
				'label' => 'Segments',
				'instructions' => 'Add segments to display in a bento grid layout.',
				'layout' => 'block',
				'button_label' => 'Add Segment',
				'min' => 1,
				'max' => 8,
			])
				->addSelect('segment_type', [
					'label' => 'Segment Type',
					'choices' => [
						'single' => 'Single Tile',
						'double' => 'Double Tiles'
					],
					'default_value' => 'single',
					'required' => 1,
				])
				->addGroup('tile_one', [
					'label' => 'First Tile'
				])
					->addImage('tile_image',[
						'label' => 'Tile Image',
						'return_format' => 'array',
						'preview_size' => 'medium',
						'default_value' => get_template_directory_uri() . '/screenshot.jpg',
					])
					->addText('tile_title', [
						'label' => 'Tile Title',
						'required' => 1,
					])
					->addTextarea('tile_text', [
						'label' => 'Tile Text',
						'rows' => '8',
						'new_lines' => 'br',
					])
					->addField('tile_buttons', 'clone', [
						'clone' => [
							'group_action_group',
						],
					])
				->endGroup()
				->addGroup('tile_two', [
					'label' => 'Second Tile',
					'conditional_logic' => [
						[
							[
								'field' => 'segment_type',
								'operator' => '==',
								'value' => 'double',
							]
						]
					]
				])
					->addImage('tile_image',[
						'label' => 'Tile Image',
						'return_format' => 'array',
						'preview_size' => 'medium',
						'default_value' => get_template_directory_uri() . '/screenshot.jpg',
					])
					->addText('tile_title', [
						'label' => 'Tile Title',
						'required' => 1,
					])
					->addTextarea('tile_text', [
						'label' => 'Tile Text',
						'rows' => '8',
						'new_lines' => 'br',
					])
					->addField('tile_buttons', 'clone', [
						'clone' => [
							'group_action_group',
						],
					])
				->endGroup()
			->endRepeater()
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
