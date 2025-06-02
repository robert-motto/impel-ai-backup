<?php

add_action('init', 'register_nav');
function register_nav()
{
	register_nav_menus(
		array(
			'main_menu' => __('Main menu'),
			'header_menu' => __('Header menu'),
			'footer_menu_col_1' => __('Footer - column 1'),
			'footer_menu_col_2' => __('Footer - column 2'),
			'footer_menu_col_3' => __('Footer - column 3'),
			'footer_menu_col_4' => __('Footer - column 4'),
		)
	);
}

function add_additional_class_on_li($classes, $item, $args)
{
	if (isset($args->link_class)) {
		$classes[] = $args->link_class;
	}
	return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

class WPSE_78121_Sublevel_Walker extends Walker_Nav_Menu
{
	function start_lvl(&$output, $depth = 0, $args = null)
	{
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent <div class='sub-menu-wrap'><ul class='sub-menu'>\n";
	}

	function end_lvl(&$output, $depth = 0, $args = null)
	{
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul></div>\n";
	}

	function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
	{
		// Get the menu item
		$menu_item = $data_object;

		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ($depth) ? str_repeat($t, $depth) : '';

		$classes = empty($menu_item->classes) ? array() : (array) $menu_item->classes;
		$classes[] = 'menu-item-' . $menu_item->ID;

		// Add has-submenu class if this item has ACF submenu
		$has_submenu = get_field('has_submenu', $menu_item->ID);
		if ($has_submenu === 'y') {
			$classes[] = 'has-submenu';
		}

		$args = apply_filters('nav_menu_item_args', $args, $menu_item, $depth);
		$class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $menu_item, $args, $depth));
		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth);

		$li_atts = array();
		$li_atts['id'] = !empty($id) ? $id : '';
		$li_atts['class'] = !empty($class_names) ? $class_names : '';
		$li_atts = apply_filters('nav_menu_item_attributes', $li_atts, $menu_item, $args, $depth);
		$li_attributes = '';
		foreach ($li_atts as $attr => $value) {
			if (!empty($value)) {
				$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
				$li_attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$output .= $indent . '<li' . $li_attributes . '>';

		$atts = array();
		$atts['title'] = !empty($menu_item->attr_title) ? $menu_item->attr_title : '';
		$atts['target'] = !empty($menu_item->target) ? $menu_item->target : '';
		if ('_blank' === $menu_item->target && empty($menu_item->xfn)) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $menu_item->xfn;
		}

		if (!empty($menu_item->url)) {
			if (get_privacy_policy_url() === $menu_item->url) {
				$atts['rel'] = empty($atts['rel']) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
			}
			$atts['href'] = $menu_item->url;
		} else {
			$atts['href'] = '';
		}

		$atts['aria-current'] = $menu_item->current ? 'page' : '';
		$atts = apply_filters('nav_menu_link_attributes', $atts, $menu_item, $args, $depth);
		$attributes = '';
		foreach ($atts as $attr => $value) {
			if (!empty($value)) {
				$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title = apply_filters('the_title', $menu_item->title, $menu_item->ID);
		$title = apply_filters('nav_menu_item_title', $title, $menu_item, $args, $depth);

		$item_output = $args->before ?? '';
		$item_output .= '<a' . $attributes . '>';
		$item_output .= str_replace('%s', $title, $args->link_before) . $title . $args->link_after;

		// Add chevron icon for menu items with submenu
		$has_submenu = get_field('has_submenu', $menu_item->ID);
		if ($has_submenu === 'y') {
			ob_start();
			get_icon('chevron-down', [
				'classes' => 'site-top-nav__chevron',
			]);
			$item_output .= ob_get_clean();
		}

		$item_output .= '</a>';

		// Handle submenu content
		$has_submenu = get_field('has_submenu', $menu_item->ID);
		if ($has_submenu === 'y') {
			$submenu_type = get_field('submenu_type', $menu_item->ID);
			if ($submenu_type === 'grid') {
				$grid_submenu = get_field('grid_submenu', $menu_item->ID);
				if ($grid_submenu) {
					$item_output .= $this->render_grid_submenu_content($grid_submenu, $menu_item);
				}
			} elseif ($submenu_type === 'tabs') {
				$tabs_submenu = get_field('tabs_submenu', $menu_item->ID);
				if ($tabs_submenu) {
					$item_output .= $this->render_tabs_submenu_content($tabs_submenu, $menu_item);
				}
			}
		}

		$item_output .= $args->after ?? '';
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args);
	}

	private function render_grid_submenu_content($grid_submenu, $menu_item)
	{
		$output = '<div class="sub-menu-wrap sub-menu-wrap--grid">';
		$output .= '<div class="l-wrapper">';
		$output .= '<div class="sub-menu-container">';

		$output .= '<div class="sub-menu-wrap__content">';

		if (!empty($grid_submenu['title'])) {
			$output .= '<div class="sub-menu-wrap__header">';
			$output .= '<h2 class="sub-menu-wrap__title">' . esc_html($grid_submenu['title']) . '</h2>';
			if (!empty($grid_submenu['text'])) {
				$output .= '<div class="sub-menu-wrap__text">' . esc_html($grid_submenu['text']) . '</div>';
			}
			if (!empty($grid_submenu['link'])) {
				$link = $grid_submenu['link'];
				$output .= '<a href="' . esc_url($link['url']) . '" class="sub-menu-wrap__link">';
				$output .= '<span class="text">' . esc_html($link['title']) . '</span>';
				$output .= '<span class="arrow-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4.16406 10H15.8307M15.8307 10L10.8307 15M15.8307 10L10.8307 5" stroke="#F6F5FA" stroke-linecap="round" stroke-linejoin="round"></path></svg></span>';
				$output .= '</a>';
			}
			$output .= '</div>';
		}

		if (!empty($grid_submenu['menu_items'])) {
			$output .= '<div class="sub-menu-wrap__grid">';
			$items_count = count($grid_submenu['menu_items']);
			$column_size = ceil($items_count / 2);
			$column1 = array_slice($grid_submenu['menu_items'], 0, $column_size);
			$column2 = array_slice($grid_submenu['menu_items'], $column_size);

			$output .= '<div class="sub-menu-wrap__grid-column">';
			foreach ($column1 as $item) {
				$output .= $this->render_grid_item($item);
			}
			$output .= '</div>';

			$output .= '<div class="sub-menu-wrap__grid-column">';
			foreach ($column2 as $item) {
				$output .= $this->render_grid_item($item);
			}
			$output .= '</div>';

			$output .= '</div>';
		}

		// Add image section if available
		if (!empty($grid_submenu['image_section'])) {
			$image_section = $grid_submenu['image_section'];
			$output .= '<div class="sub-menu-wrap__image-section">';
			if (!empty($image_section['image'])) {
				$output .= '<div class="sub-menu-wrap__image">';
				$output .= wp_get_attachment_image($image_section['image'], 'large');
				$output .= '</div>';
			}
			if (!empty($image_section['label'])) {
				$output .= '<div class="sub-menu-wrap__image-label">' . esc_html($image_section['label']) . '</div>';
			}
			if (!empty($image_section['image_heading'])) {
				$output .= '<h3 class="sub-menu-wrap__image-heading">' . esc_html($image_section['image_heading']) . '</h3>';
			}
			if (!empty($image_section['image_subheading'])) {
				$output .= '<div class="sub-menu-wrap__image-subheading">' . esc_html($image_section['image_subheading']) . '</div>';
			}
			if (!empty($image_section['link'])) {
				$link = $image_section['link'];
				$output .= '<a href="' . esc_url($link['url']) . '" class="sub-menu-wrap__image-link">';
				$output .= '<span class="text">' . esc_html($link['title']) . '</span>';
				$output .= '<span class="arrow-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4.16406 10H15.8307M15.8307 10L10.8307 15M15.8307 10L10.8307 5" stroke="#F6F5FA" stroke-linecap="round" stroke-linejoin="round"></path></svg></span>';
				$output .= '</a>';
			}
			$output .= '</div>';
		}

		$output .= '</div>'; // Close .sub-menu-wrap__content

		// Add grey bar if enabled
		$grey_bar = get_field('grey_bar', $menu_item->ID);
		if (!empty($grey_bar) && $grey_bar['show_grey_bar'] === 'y') {
			$output .= '<div class="sub-menu-wrap__grey-bar">';

			ob_start();
			get_icon('grid');
			$output .= ob_get_clean();

			if (!empty($grey_bar['grey_bar_text'])) {
				$output .= '<p class="sub-menu-wrap__grey-bar-text">' . esc_html($grey_bar['grey_bar_text']) . '</p>';
			}
			if (!empty($grey_bar['grey_bar_link'])) {
				$link = $grey_bar['grey_bar_link'];
				$output .= '<a href="' . esc_url($link['url']) . '" class="sub-menu-wrap__grey-bar-link">' . esc_html($link['title']) . '</a>';
			}
			$output .= '</div>';
		}

		$output .= '</div></div></div>';
		return $output;
	}

	private function render_grid_item($item)
	{
		$output = '<div class="sub-menu-wrap__grid-item">';
		if (!empty($item['link'])) {
			$output .= '<a href="' . esc_url($item['link']['url']) . '" class="sub-menu-wrap__grid-link">';
			$output .= '<h3 class="sub-menu-wrap__grid-title">' . esc_html($item['link']['title']) . '</h3>';
			if (!empty($item['description'])) {
				$output .= '<div class="sub-menu-wrap__grid-desc">' . esc_html($item['description']) . '</div>';
			}
			$output .= '</a>';
		}
		$output .= '</div>';
		return $output;
	}

	private function render_tabs_submenu_content($tabs_submenu, $menu_item)
	{
		$output = '<div class="sub-menu-wrap sub-menu-wrap--tabs">';
		$output .= '<div class="l-wrapper">';
		$output .= '<div class="sub-menu-container">';
		$output .= '<div class="sub-menu-wrap__tabs">';

		// Tabs navigation
		$output .= '<div class="sub-menu-wrap__tabs-nav">';
		foreach ($tabs_submenu['tabs'] as $index => $tab) {
			$active_class = $index === 0 ? ' is-active' : '';
			$output .= '<button class="sub-menu-wrap__tab-btn' . $active_class . '" data-tab="' . $index . '">';
			$output .= esc_html($tab['tab_title']);
			$output .= '<span class="sub-menu-wrap__tab-chevron"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
			$output .= '</button>';
		}
		$output .= '</div>';

		// Tabs content
		$output .= '<div class="sub-menu-wrap__tabs-content">';
		foreach ($tabs_submenu['tabs'] as $index => $tab) {
			$active_class = $index === 0 ? ' is-active' : '';
			$output .= '<div class="sub-menu-wrap__tab-panel' . $active_class . '" data-tab="' . $index . '">';

			// Links in two columns
			if (!empty($tab['links'])) {
				$output .= '<div class="sub-menu-wrap__tab-links">';
				$links_count = count($tab['links']);
				$column_size = ceil($links_count / 2);
				$column1 = array_slice($tab['links'], 0, $column_size);
				$column2 = array_slice($tab['links'], $column_size);

				$output .= '<div class="sub-menu-wrap__tab-links-column">';
				foreach ($column1 as $link) {
					$output .= $this->render_tab_link($link);
				}
				$output .= '</div>';

				$output .= '<div class="sub-menu-wrap__tab-links-column">';
				foreach ($column2 as $link) {
					$output .= $this->render_tab_link($link);
				}
				$output .= '</div>';
				$output .= '</div>';
			}

			// Image section
			if (!empty($tab['tab_image'])) {
				$output .= '<div class="sub-menu-wrap__image-section">';
				$output .= '<div class="sub-menu-wrap__image">';
				$output .= wp_get_attachment_image($tab['tab_image'], 'large');
				$output .= '</div>';
				if (!empty($tab['label'])) {
					$output .= '<div class="sub-menu-wrap__image-label">' . esc_html($tab['label']) . '</div>';
				}
				if (!empty($tab['image_heading'])) {
					$output .= '<h3 class="sub-menu-wrap__image-heading">' . esc_html($tab['image_heading']) . '</h3>';
				}
				if (!empty($tab['image_subheading'])) {
					$output .= '<div class="sub-menu-wrap__image-subheading">' . esc_html($tab['image_subheading']) . '</div>';
				}
				if (!empty($tab['link'])) {
					$link = $tab['link'];
					$output .= '<a href="' . esc_url($link['url']) . '" class="sub-menu-wrap__image-link">';
					$output .= '<span class="text">' . esc_html($link['title']) . '</span>';
					$output .= '<span class="arrow-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4.16406 10H15.8307M15.8307 10L10.8307 15M15.8307 10L10.8307 5" stroke="#F6F5FA" stroke-linecap="round" stroke-linejoin="round"></path></svg></span>';
					$output .= '</a>';
				}
				$output .= '</div>';
			}

			$output .= '</div>';
		}
		$output .= '</div></div>';

		// Add grey bar if enabled
		$grey_bar = get_field('grey_bar', $menu_item->ID);
		if (!empty($grey_bar) && $grey_bar['show_grey_bar'] === 'y') {
			$output .= '<div class="sub-menu-wrap__grey-bar">';
			if (!empty($grey_bar['grey_bar_text'])) {
				$output .= '<p class="sub-menu-wrap__grey-bar-text">' . esc_html($grey_bar['grey_bar_text']) . '</p>';
			}
			if (!empty($grey_bar['grey_bar_link'])) {
				$link = $grey_bar['grey_bar_link'];
				$output .= '<a href="' . esc_url($link['url']) . '" class="sub-menu-wrap__grey-bar-link">' . esc_html($link['title']) . '</a>';
			}
			$output .= '</div>';
		}

		$output .= '</div></div></div>';
		return $output;
	}

	private function render_tab_link($link)
	{
		$output = '';
		if (!empty($link['link'])) {
			$output .= '<a href="' . esc_url($link['link']['url']) . '" class="sub-menu-wrap__tab-link">';
			$output .= '<span class="sub-menu-wrap__tab-link-title">' . esc_html($link['link']['title']) . '</span>';
			if (!empty($link['text'])) {
				$output .= '<span class="sub-menu-wrap__tab-link-desc">' . esc_html($link['text']) . '</span>';
			}
			$output .= '</a>';
		}
		return $output;
	}
}
