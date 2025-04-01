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
			->addRepeater('breadcrumbs', [
				'label' => 'Breadcrumbs',
				'instructions' => 'Add breadcrumb links. Order matters.',
				'layout' => 'table',
				'button_label' => 'Add Breadcrumb',
				'min' => 1,
			])
				->addText('label', [
					'label' => 'Label',
					'instructions' => 'Text for the breadcrumb',
					'required' => 1,
					'default_value' => 'Home',
				])
				->addText('link', [
					'label' => 'Link',
					'instructions' => 'Link for the breadcrumb (leave empty for current page)',
					'default_value' => '/',
				])
			->endRepeater()
			->addText('caption', [
				'label' => 'Caption',
				'instructions' => 'Small text that appears above the heading',
				'default_value' => 'Impel for Enterprise Dealer Group',
			])
			->addWysiwyg('heading', [
				'label' => 'Heading',
				'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'visual',
				'delay' => 0,
				'new_lines' => 'br',
				'default_value' => 'Transform Your Automotive Business with Impel',
			])
			->addWysiwyg('subheading', [
				'label' => 'Subheading',
				'instructions' => 'Enter the subheading text.',
				'media_upload' => 0,
				'toolbar' => 'basic',
				'tabs' => 'all',
				'delay' => 0,
				'default_value' => 'The only AI-powered platform driving every stage of your business—from research to purchase and beyond.',
			])
			->addRepeater('icon_points', [
				'label' => 'Icon Points',
				'instructions' => 'Add bullet points with check circle icons',
				'layout' => 'block',
				'button_label' => 'Add Point',
				'min' => 0,
				'max' => 4,
			])
				->addText('text', [
					'label' => 'Text',
					'instructions' => 'Text for this point',
					'required' => 1,
					'default_value' => '35% increase in return sales to the same dealer',
				])
			->endRepeater()
			->addField('buttons', 'clone', [
				'clone' => [
					'group_buttons',
				]
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
			->addRepeater('partner_logos', [
				'label' => 'Partner Logos',
				'instructions' => 'Add partner logos for the bottom section',
				'layout' => 'table',
				'button_label' => 'Add Logo',
				'min' => 0,
			])
				->addImage('logo', [
					'label' => 'Logo',
					'instructions' => 'Upload a partner logo (SVG recommended)',
					'return_format' => 'array',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				])
				->addText('name', [
					'label' => 'Company Name',
					'instructions' => 'For accessibility purposes',
				])
			->endRepeater()
		->endGroup()
		->setLocation('block', '==', 'acf/' . $path);
	return $name;
