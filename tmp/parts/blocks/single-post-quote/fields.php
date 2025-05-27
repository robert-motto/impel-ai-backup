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
			->addField('content', 'clone', [
				'clone' => [
					'group_content',
				]
			])
			->addText('author')
			->addText('author_title')
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
