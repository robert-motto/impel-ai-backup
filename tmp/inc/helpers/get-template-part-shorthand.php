<?php

/**
 * Get ACF components
 *
 * @param array $components [component_name => data]
 * @return void
 */
function get_acf_components($components){
	foreach($components as $name => $data){
		get_acf_component($name, $data);
	}
}

/**
 * Get ACF component
 *
 * @param string $component_name
 * @param array $data
 * @return void
 */
function get_acf_component($component_name, $data = []){
	get_template_part("parts/acf-components/{$component_name}/template", null, $data);
}

/**
 * Get components
 *
 * @param array $components [component_name => data]
 * @return void
 */
function get_components($components){
	foreach($components as $name => $data){
		get_component($name, $data);
	}
}

/**
 * Get component
 *
 * @param string $component_name
 * @param array $data
 * @return void
 */
function get_component($component_name, $data = []){
	get_template_part("parts/components/{$component_name}", null, $data);
}

/**
 * Get icon
 *
 * @param string $icon_name
 * @param array $data
 * @return void
 */
function get_icon($icon_name, $data = []){
	get_template_part("parts/icons/{$icon_name}", null, $data);
}

/**
 * Get block
 *
 * @param string $block_name
 * @param array $data
 * @return void
 */
function get_block($block_name, $data = []){
	get_template_part("parts/blocks/{$block_name}/template", null, $data);
}

/**
 * Get section
 *
 * @param string $section_name
 * @param array $data
 * @return void
 */
function get_section($section_name, $data = []){
	get_template_part("parts/sections/{$section_name}", null, $data);
}
