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
			'instructions' => 'Displays a section with a main content area and a grid of related content cards.',
			'layout' => 'block',
		])
			->addField('section_settings', 'clone', [
				'clone' => [
					'group_section_settings',
				]
			])
			->addText('caption', [
				'label' => 'Caption',
				'instructions' => 'Optional short text above the heading.',
				'default_value' => '',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
				'default_value' => 'Discover More',
			])
			->addWysiwyg('content', [
				'label' => 'Body Content',
				'instructions' => 'Optional main content text below the heading.',
				'media_upload' => 0,
				'toolbar' => 'full',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => '',
			])
			->addField('buttons', 'clone', [
				'clone' => [
					'group_buttons',
				]
			])
			->addRepeater('related_items', [
				'label' => 'Related Items',
				'instructions' => 'Add related content cards.',
				'min' => 1,
				'max' => 3,
				'layout' => 'block',
				'button_label' => 'Add Related Item',
			])
				->addText('item_heading', [
					'label' => 'Item Heading',
					'default_value' => 'Item Title',
				])
				->addTextarea('item_description', [
					'label' => 'Item Description',
					'rows' => 3,
					'new_lines' => 'wpautop',
					'default_value' => 'Short description or excerpt of the related content.',
				])
				->addLink('item_link', [
					'label' => 'Item Link',
					'instructions' => 'Link to the related content details page.',
					'return_format' => 'array',
					'required' => 1,
					'default_value' => [
						'title' => 'Learn More',
						'url' => '#',
						'target' => '',
					]
				])
			->endRepeater()
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
