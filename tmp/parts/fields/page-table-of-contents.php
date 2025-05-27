<?php
	use StoutLogic\AcfBuilder\FieldsBuilder;
	$options = new FieldsBuilder('page_table_of_contents');
	$options
		->addTab('Reusable block')
			->addText('reusable_block_name', [
				'instructions' => 'Enter the name of the reusable block you want to display under the post content.',
			])
		->setLocation('page_template', '==', 'page-table-of-contents.php');
	return $options;
