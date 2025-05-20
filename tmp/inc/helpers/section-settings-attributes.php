<?php

function section_settings_classes($group) {

	$mode = $group['section_settings_group']['mode'] ?? 'is-light';
	$pt   = $group['section_settings_group']['pt'] ?? 'pt-lg';
	$pb   = $group['section_settings_group']['pb'] ?? 'pb-lg';

	return $mode . ' ' . $pt . ' ' . $pb;
}

function section_settings_mode_classes($group) {
	$mode = $group['section_settings_group']['mode'] ?? 'is-light';

	return $mode;
}

function section_settings_padding_classes($group) {
	$pt   = $group['section_settings_group']['pt'] ?? 'pt-lg';
	$pb   = $group['section_settings_group']['pb'] ?? 'pb-lg';

	return $pt . ' ' . $pb;
}



function section_settings_id($group) {
	$id = $group['section_settings_group']['id'] ?? '';
	return $id ? 'id="' . $id . '"' : '';
}
