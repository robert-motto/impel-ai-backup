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
			->addButtonGroup('player', [
				'label'   => 'Select player',
				'choices' => [
					'wp'      => 'WordPress',
					'youtube' => 'Youtube',
					'vimeo'   => 'Vimeo',
				],
				'default_value' => 'wp',
			])
			->addFile('file',[
				'instructions' => 'Allowed file types: mp4',
				'mime_types'   => 'mp4',
			])
				->conditional('player', '==', 'wp')
			->addText('embed_link')
				->conditional('player', '==', 'youtube')
					->or('player', '==', 'vimeo')
			->addText('embed_title')
				->conditional('player', '==', 'youtube')
					->or('player', '==', 'vimeo')
			->addImage('photo', [
				'label' => 'Photo for the video player cover',
				'instructions' => 'Sizing: 2000 x 1126px',
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
