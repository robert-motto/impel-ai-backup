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
			->addField('subheading', 'clone', [
				'clone' => [
					'group_subheading',
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
			->addImage('image',[
				'instructions' => 'Sizing: 2800 x 1520px',
			])
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path)
			->or('page_template', '==', 'page-table-of-contents.php');
	return $name;
