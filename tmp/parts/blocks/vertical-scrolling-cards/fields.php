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
    'instructions' => 'Short text above the heading',
    'default_value' => 'Tagline',
  ])
  ->addWysiwyg('heading', [
    'label' => 'Heading',
    'instructions' => 'Enter the main heading text. Use Enter/Return for line breaks.',
    'media_upload' => 0,
    'toolbar' => 'basic',
    'tabs' => 'visual',
    'delay' => 0,
    'new_lines' => 'br',
    'default_value' => 'Short heading goes here',
  ])
  ->addWysiwyg('content', [
    'label' => 'Content',
    'instructions' => 'Enter the main content text.',
    'media_upload' => 0,
    'toolbar' => 'full',
    'tabs' => 'all',
    'delay' => 0,
    'default_value' => 'Ornare purus enim pulvinar at volutpat. Arcu lobortis elementum eu consectetur. Diam proin et senectus condimentum imperdiet vitae nisi. Velit habitasse odio libero.',
  ])
  ->addField('buttons_group', 'clone', [
    'clone' => [
      'group_buttons',
    ]
  ])
  ->addButtonGroup('cards_media_type', [
    'label' => 'Cards Media Type',
    'choices' => [
      'image' => 'Image',
      'icon' => 'Icon',
    ],
    'default_value' => 'image',
    'layout' => 'horizontal',
    'return_format' => 'value',
  ])
  ->addRepeater('cards', [
    'label' => 'Scrolling Cards',
    'instructions' => 'Add cards to the right scrolling section (maximum 5)',
    'min' => 1,
    'max' => 5,
    'layout' => 'block',
    'button_label' => 'Add Card',
  ])
  ->addText('badge_label', [
    'label' => 'Badge Label',
    'instructions' => 'Optional label badge to show above card heading',
    'default_value' => 'Label',
  ])
  ->addWysiwyg('headline', [
    'label' => 'Card Heading',
    'instructions' => 'Heading for this card',
    'media_upload' => 0,
    'toolbar' => 'basic',
    'tabs' => 'visual',
    'delay' => 0,
    'default_value' => 'Medium length section heading goes here',
  ])
  ->addWysiwyg('body', [
    'label' => 'Card Content',
    'instructions' => 'Main content for this card',
    'media_upload' => 0,
    'toolbar' => 'full',
    'tabs' => 'all',
    'delay' => 0,
    'default_value' => 'Ornare purus enim pulvinar at volutpat. Arcu lobortis elementum eu consectetur. Diam proin et senectus condimentum imperdiet vitae nisi. Velit habitasse odio libero.',
  ])
  ->addLink('card_link', [
    'label' => 'Card Link',
    'instructions' => 'Optional link for the card',
    'return_format' => 'array',
  ])
  ->addImage('image', [
    'label' => 'Card Image',
    'instructions' => 'Upload an image. Recommended size: 560×373px (2x for retina).',
    'return_format' => 'array',
    'preview_size' => 'medium',
  ])
  ->conditional('cards_media_type', '==', 'image')
  ->addImage('icon', [
    'label' => 'Card Icon',
    'instructions' => 'Upload an SVG icon. Will be displayed at a reasonable size.',
    'return_format' => 'array',
    'preview_size' => 'thumbnail',
    'mime_types' => 'svg',
  ])
  ->conditional('cards_media_type', '==', 'icon')
  ->endRepeater()
  ->addTrueFalse('has_background', [
    'label' => 'Use Background Color',
    'instructions' => 'Add background color to the section',
    'default_value' => 0,
    'ui' => 1,
  ])
  ->addSelect('background_color', [
    'label' => 'Background Color',
    'instructions' => 'Select background color',
    'choices' => [
      'light' => 'Light (Gray)',
      'white' => 'White',
      'dark' => 'Dark',
    ],
    'default_value' => 'light',
    'return_format' => 'value',
    'multiple' => 0,
    'ui' => 1,
  ])
  ->conditional('has_background', '==', 1)
  ->endGroup()
  ->setLocation('block', '==', 'acf/' . $path);
return $name;
