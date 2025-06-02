<?php
	use StoutLogic\AcfBuilder\FieldsBuilder;
	$path = basename(__DIR__);
	$name = str_replace('-', '_', $path);
	$group_name = $name . '_group';
	$group_label = str_replace('-', ' ', $path);
	$name = new FieldsBuilder($name);
	$name
		->addGroup($group_name, [
			'label' => ucwords($group_label) . ' Component',
			'instructions' => '',
			'layout' => 'block',
		])
			->addSelect('alignment', [
				'label' => 'Alignment',
				'choices' => [
					'central' => 'Central',
					'left' => 'Left',
				],
				'default_value' => 'central',
				'return_format' => 'value',
				'ui' => 1,
			])
			->addText('caption', [
				'label' => 'Caption',
			])
			->addText('heading', [
				'label' => 'Heading',
			])
			->addSelect('heading_size', [
				'label' => 'Heading size',
				'choices' => [
					'small' => 'Small',
					'regular' => 'Regular',
					'large' => 'Large',
				],
				'default_value' => 'regular',
				'return_format' => 'value',
				'ui' => 1,
			])
			->addTrueFalse('use_list_subheading', [
				'label' => 'Use List for Subheading?',
				'instructions' => 'Toggle on to use a bulleted list with icons for the subheading. Otherwise, a simple text area will be used.',
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text'  => 'List',
				'ui_off_text' => 'Text',
			])
			->addTextarea('subheading', [
				'label' => 'Subheading',
				'rows' => '4',
				'new_lines' => 'br',
			])
				->conditional('use_list_subheading', '==', '0')
			->addSelect('subheading_font_size', [
				'label' => 'Subheading Font Size',
				'choices' => [
					'regular' => 'Regular (18px)',
					'small'   => 'Small (14px)',
				],
				'default_value' => 'regular',
				'return_format' => 'value',
				'ui'            => 1,
			])
				->conditional('use_list_subheading', '==', '0')
			->addRepeater('subheading_list', [
				'label' => 'Subheading List',
				'instructions' => 'Add items for the bulleted list. The icon is predefined.',
				'layout' => 'block',
				'button_label' => 'Add List Item',
			])
				->conditional('use_list_subheading', '==', '1')
				->addText('list_item', [
					'label' => 'List Item Text',
				])
			->endRepeater()
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
