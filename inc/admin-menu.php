<?php
	function change_post_menu_position($name, $position) {
		global $menu;
		// Find the existing menu item
		foreach ($menu as $key => $value) {
			if ($value[0] == $name) {
				// Remove the existing menu item
				unset($menu[$key]);
				// Add the menu item at a new position
				$menu[$position] = $value; // Example: Move to position 20
				break;
			}
		}
	}
	add_action('admin_menu', function() {
		change_post_menu_position('Pages', 4);
	});
