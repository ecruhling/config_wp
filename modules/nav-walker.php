<?php

namespace Resource\Config_WP\NavWalker;

/**
 * Class NavWalker
 *
 * Bootstrap 4 walker with cleaner markup for wp_nav_menu()
 * For use with Sage >= 8.5
 *
 * Based on Soil NavWalker
 * @url https://github.com/roots/soil
 *
 *
 * Walker_Nav_Menu (WordPress default) example output:
 *   <li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8"><a href="/">Home</a></li>
 *
 * NavWalker example output:
 *   <li class="nav-item menu-item menu-home"><a class="nav-link" href="/">Home</a></li>
 *
 */
class NavWalker extends \Walker_Nav_Menu
{
	/**
	 * @var bool
	 */
	private $cpt; // Boolean, is current post a custom post type
	/**
	 * @var false|string
	 */
	private $archive; // Stores the archive page for current URL

	/**
	 * NavWalker constructor.
	 */
	public function __construct()
	{
		add_filter('nav_menu_css_class', array($this, 'cssClasses'), 10, 2);
		add_filter('nav_menu_item_id', '__return_null');
		$cpt = get_post_type();
		$this->cpt = in_array($cpt, get_post_types(array('_builtin' => false)));
		$this->archive = get_post_type_archive_link($cpt);
	}

	/**
	 * Check item classes for current or active
	 *
	 * @param $classes
	 *
	 * @return int
	 */
	public function checkCurrent($classes)
	{
		return preg_match('/(current[-_])|active/', $classes);
	}

	// @codingStandardsIgnoreStart

	/**
	 * Add dropdown menu class to dropdown UL
	 *
	 * @param string $output
	 * @param int $depth
	 * @param array $args
	 */
	function start_lvl(&$output, $depth = 0, $args = [])
	{
		$output .= "\n<ul class=\"dropdown-menu\" aria-labelledby=\"navbarDropdownMenuLink\">\n";
	}

	/**
	 * Add required Bootstrap 4 classes to anchor links.
	 *
	 * @param string $output
	 * @param \WP_Post $item
	 * @param int $depth
	 * @param array $args
	 * @param int $id
	 */
	function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
	{
		$item_html = '';

		parent::start_el($item_html, $item, $depth, $args);

		if ($item->is_subitem) {
			$item_html = str_replace('<a', '<a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"', $item_html);
			$item_html = str_replace('</a>', ' <b class="caret"></b></a>', $item_html);
		} else {
			$item_html = str_replace('<a', '<a class="nav-link"', $item_html);
		}

		$item_html = apply_filters('wp_nav_menu_item', $item_html);

		$output .= $item_html;
	}

	/**
	 * Add active classes to active items & sub items
	 *
	 * @param object $element
	 * @param array $children_elements
	 * @param int $max_depth
	 * @param int $depth
	 * @param array $args
	 * @param string $output
	 */
	public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
	{
		$element->is_subitem = ((!empty($children_elements[$element->ID]) && (($depth + 1) < $max_depth || ($max_depth === 0))));

		if ($element->is_subitem) {
			foreach ($children_elements[$element->ID] as $child) {
				if ($child->current_item_parent || $this->url_compare($this->archive, $child->url)) {
					$element->classes[] = 'active';
				}
			}
		}

		$element->is_active = (!empty($element->url) && strpos($this->archive, $element->url));

		if ($element->is_active) {
			$element->classes[] = 'active';
		}

		parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}

	// @codingStandardsIgnoreEnd

	/**
	 * Clean up css classes
	 *
	 * @param $classes
	 * @param $item
	 *
	 * @return array
	 */
	public function cssClasses($classes, $item)
	{
		$slug = sanitize_title($item->title);

		// Fix core `active` behavior for custom post types
		if ($this->cpt) {
			$classes = str_replace('current_page_parent', '', $classes);

			if ($this->url_compare($this->archive, $item->url)) {
				$classes[] = 'active';
			}
		}

		// Remove most core classes
		$classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes);
		$classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);

		// Add `menu-item` class & re-add core `menu-item` class
		$classes[] = 'nav-item menu-item';

		// Add `dropdown` class & re-add core `menu-item-has-children` class on parent elements
		if ($item->is_subitem) {
			$classes[] = 'dropdown menu-item-has-children';
		}

		// Add `menu-<slug>` class
		$classes[] = 'menu-' . $slug;

		$classes = array_unique($classes);
		$classes = array_map('trim', $classes);

		return array_filter($classes);
	}

	/**
	 * Make a URL relative
	 *
	 * Utility function, from soil
	 * @url https://github.com/roots/soil
	 *
	 * @param $input
	 *
	 * @return string
	 */
	public function root_relative_url($input)
	{
		if (is_feed()) {
			return $input;
		}
		$url = parse_url($input);
		if (!isset($url['host']) || !isset($url['path'])) {
			return $input;
		}
		$site_url = parse_url(network_home_url());  // falls back to home_url
		if (!isset($url['scheme'])) {
			$url['scheme'] = $site_url['scheme'];
		}
		$hosts_match = $site_url['host'] === $url['host'];
		$schemes_match = $site_url['scheme'] === $url['scheme'];
		$ports_exist = isset($site_url['port']) && isset($url['port']);
		$ports_match = ($ports_exist) ? $site_url['port'] === $url['port'] : true;
		if ($hosts_match && $schemes_match && $ports_match) {
			return wp_make_link_relative($input);
		}

		return $input;
	}

	/**
	 * Compare URL against relative URL
	 *
	 * Utility function, from Soil
	 * @url https://github.com/roots/soil
	 *
	 * @param $url
	 * @param $rel
	 *
	 * @return bool
	 */
	public function url_compare($url, $rel)
	{
		$url = trailingslashit($url);
		$rel = trailingslashit($rel);

		return ((strcasecmp($url, $rel) === 0) || $this->root_relative_url($url) == $rel);
	}

}

/**
 * Clean up wp_nav_menu_args
 *
 * Remove the container
 * Remove the id="" on nav menu items
 *
 * @param string $args
 *
 * @return array
 */
function nav_menu_args($args = '')
{
	$nav_menu_args = [];
	$nav_menu_args['container'] = false;


	if (is_array($args) && !$args['items_wrap']) {
		$nav_menu_args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';
	}

	if (!$args['walker']) {
		$nav_menu_args['walker'] = new NavWalker();
	}


	return array_merge($args, $nav_menu_args);
}

add_filter('wp_nav_menu_args', __NAMESPACE__ . '\\nav_menu_args');
add_filter('nav_menu_item_id', '__return_null');
