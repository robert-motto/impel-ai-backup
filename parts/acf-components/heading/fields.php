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
			->addButtonGroup('has_caption', [
				'label' => 'Do you want to add a caption?',
				'choices' => [
					'y' => 'Yes',
					'n' => 'No',
				],
				'default_value' => 'n',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addButtonGroup('caption_size', [
				'label' => 'Caption font size',
				'instructions' => 'Values displayed in px',
				'choices' => [
					'1' => '15',
					'2' => '14',
					'3' => '13',
				],
				'default_value' => '2',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
				->conditional('has_caption', '==', 'y')
			->addText('caption')
				->conditional('has_caption', '==', 'y')
			->addButtonGroup('title_size', [
				'label' => 'Title font size',
				'instructions' => 'Values displayed in px',
				'choices' => [
					'h1' => '64',
					'h2' => '56',
					'h3' => '44',
					'h4' => '32',
					'h5' => '24',
					'h6' => '20',
					'h7' => '17',
					'h8' => '15',
				],
				'default_value' => 'h2',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addButtonGroup('title_weight', [
				'label' => 'Title font weight',
				'choices' => [
					'thin' => 'thin',
					'light' => 'light',
					'regular' => 'regular',
					'medium' => 'medium',
					'semibold' => 'semibold',
					'bold' => 'bold',
					'extrabold' => 'extrabold',
				],
				'default_value' => 'regular',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addWysiwyg('title', [
				'instructions' => 'Remember to select correct tag for the title',
				'media_upload' => 0,
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
