<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$options = new FieldsBuilder('main_menu_item_fields');
$options
  ->addButtonGroup('has_submenu', [
    'label' => 'Do you want to add a submenu?',
    'choices' => [
      'y' => 'Yes',
      'n' => 'No',
    ],
    'default_value' => 'n',
    'layout' => 'horizontal',
    'return_format' => 'value',
  ])
  ->addButtonGroup('submenu_type', [
    'label' => 'Submenu type',
    'choices' => [
      'grid' => 'Grid Layout',
      'tabs' => 'Tabs Layout',
    ],
    'default_value' => 'grid',
    'layout' => 'horizontal',
    'return_format' => 'value',
  ])
  ->conditional('has_submenu', '==', 'y')

  // Grid Layout Submenu
  ->addGroup('grid_submenu', [
    'label' => 'Grid Layout Submenu',
  ])
  ->conditional('has_submenu', '==', 'y')
  ->and('submenu_type', '==', 'grid')
  ->addText('title')
  ->addTextarea('text')
  ->addLink('link')
  ->addRepeater('menu_items', [
    'label' => 'Menu Items',
    'button_label' => 'Add Menu Item',
    'layout' => 'block',
  ])
  ->addLink('link')
  ->addTextarea('description')
  ->endRepeater()
  // Add image section for grid layout
  ->addGroup('image_section', [
    'label' => 'Image Section',
  ])
  ->addImage('image', [
    'label' => 'Image',
    'instructions' => 'Image to show in the grid layout',
    'return_format' => 'id',
    'preview_size' => 'medium',
    'library' => 'all',
  ])
  ->addText('label', [
    'label' => 'Label',
    'instructions' => 'Label text to appear above the heading',
  ])
  ->addText('image_heading', [
    'label' => 'Image Heading',
  ])
  ->addTextarea('image_subheading', [
    'label' => 'Image Subheading',
  ])
  ->addLink('link', [
    'label' => 'Link',
    'instructions' => 'Link to appear below the subheading',
    'return_format' => 'array',
  ])
  ->endGroup()
  ->endGroup()

  // Tabs Layout Submenu
  ->addGroup('tabs_submenu', [
    'label' => 'Tabs Layout Submenu',
  ])
  ->conditional('has_submenu', '==', 'y')
  ->and('submenu_type', '==', 'tabs')
  ->addRepeater('tabs', [
    'label' => 'Tabs',
    'button_label' => 'Add Tab',
    'layout' => 'block',
  ])
  ->addText('tab_title')
  ->addImage('tab_image', [
    'label' => 'Tab Image',
    'instructions' => 'Image to show when this tab is active',
    'return_format' => 'id',
    'preview_size' => 'medium',
    'library' => 'all',
  ])
  ->addText('label', [
    'label' => 'Label',
    'instructions' => 'Label text to appear above the heading',
  ])
  ->addText('image_heading', [
    'label' => 'Image Heading',
  ])
  ->addTextarea('image_subheading', [
    'label' => 'Image Subheading',
  ])
  ->addLink('link', [
    'label' => 'Link',
    'instructions' => 'Link to appear below the subheading',
    'return_format' => 'array',
  ])
  ->addRepeater('links', [
    'label' => 'Links',
    'button_label' => 'Add Link',
    'layout' => 'block',
  ])
  ->addLink('link')
  ->addTextarea('text')
  ->endRepeater()
  ->endRepeater()
  ->endGroup()

  // Grey Bar Settings (available for both submenu types)
  ->addGroup('grey_bar', [
    'label' => 'Bottom Grey Bar',
  ])
  ->conditional('has_submenu', '==', 'y')
  ->addButtonGroup('show_grey_bar', [
    'label' => 'Show grey bar at bottom?',
    'choices' => [
      'y' => 'Yes',
      'n' => 'No',
    ],
    'default_value' => 'n',
    'layout' => 'horizontal',
    'return_format' => 'value',
  ])
  ->addText('grey_bar_text', [
    'label' => 'Grey Bar Text',
    'default_value' => 'Want to see how Impel integrates with your tech stack?',
  ])
  ->conditional('show_grey_bar', '==', 'y')
  ->addLink('grey_bar_link', [
    'label' => 'Grey Bar Link',
    'return_format' => 'array',
  ])
  ->conditional('show_grey_bar', '==', 'y')
  ->endGroup()

  ->setLocation('nav_menu_item', '==', '3');

return $options;
