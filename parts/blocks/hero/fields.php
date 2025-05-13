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
			->addButtonGroup('media_position', [
				'label'   => 'Media Position',
				'choices' => [
					'background' => 'Background',
					'right'  => 'Right',
					'bottom'  => 'Bottom',
				],
				'default_value' => 'background',
				'layout'        => 'horizontal',
				'return_format' => 'value',
			])
			->addButtonGroup('text_position', [
				'label'   => 'Text Position',
				'choices' => [
					'center' => 'Center',
					'left'  => 'Left',
				],
				'default_value' => 'center',
				'layout'        => 'horizontal',
				'return_format' => 'value',
			])
				->conditional('media_position', '==', 'background')
			->addImage('image',[
				'label' => 'Hero Image',
				'instructions' => 'Recommended size: 2560px x 1008px',
				'return_format' => 'array',
				'preview_size' => 'medium',
				'default_value' => get_template_directory_uri() . '/screenshot.jpg',
			])
				->conditional('media_type', '==', 'image')
			->addField('video', 'clone', [
				'label' => 'Video',
				'clone' => [
					'group_video',
				],
				'display' => 'seamless',
				'prefix_name' => true,
			])
				->conditional('media_type', '==', 'video')
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path)
			->or('page_template', '==', 'page-table-of-contents.php');
	return $name;
