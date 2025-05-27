<?php
	use StoutLogic\AcfBuilder\FieldsBuilder;
	$options = new FieldsBuilder('Post fields');
	$options
		->addTab('Hero')
			->addButtonGroup('mode', [
				'label' => 'Color Mode',
				'choices' => [
					'is-light' => 'Light',
					'is-dark' => 'Dark',
					'is-accent' => 'Accent',
				],
				'default_value' => 'is-dark',
				'layout' => 'horizontal',
				'return_format' => 'value',
			])
			->addButtonGroup('title_size', [
				'label' => 'Title font size',
				'choices' => [
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'h7' => 'h7',
					'h8' => 'h8',
				],
				'default_value' => 'h3',
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
			->addText('written_by')
			->addText('edited_by')
			->addText('reviewed_by')
		->addTab('Reusable block')
			->addText('reusable_block_name', [
				'instructions' => 'Enter the name of the reusable block you want to display under the post content. By default it will be "Post additional sections".',
			])
		->setLocation('post_type', '==', 'post')
			->or('post_type', '==', 'custom');
	return $options;
