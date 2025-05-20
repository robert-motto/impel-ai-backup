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
			->addText('caption', [
				'label' => 'Caption',
				'instructions' => 'Short text above the heading, displayed in uppercase with letter spacing',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'bold',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
			])
			->addTextarea('content', [
				'label' => 'Body Content',
				'instructions' => 'Enter the main content text.',
				'rows' => 8,
				'new_lines' => 'br',
			])
			->addField('tab_buttons', 'clone', [
				'clone' => [
					'group_action_group',
				],
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
