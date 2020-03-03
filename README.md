# Resource Config_WP

A modular WordPress plugin that includes highly-opinionated changes to the back- and front-end. All modules are enabled or disabled using the WordPress built-in add_theme_support function.

## Installation

### via WordPress Admin Panel

1. Download the [latest zip](https://github.com/ecruhling/config_wp/releases/latest) of this repo.
2. In your WordPress admin panel, navigate to Plugins->Add New
3. Click Upload Plugin
4. Upload the zip file that you downloaded.

## Modules

* **Change 'Howdy' to 'Greetings'**<br>
  `add_theme_support('resource-change-howdy');`

* **Change footer text to cite Resource**<br>
  `add_theme_support('resource-change-footer');`

* **Move SEO Framework & Yoast metaboxes to bottom & remove SEO Framework head comment**<br>
  `add_theme_support('resource-seo-framework');`

* **Add custom login page**<br>
  `add_theme_support('resource-custom-login');`

* **Change some settings for Author pages / disables Author Archives**<br>
  `add_theme_support('resource-change-author');`

* **Change order of menu items: Posts, Pages & Media**<br>
  `add_theme_support('resource-change-menu-order');`

* **Simplify image use: don't add links to images; disable attachment pages**<br>
  `add_theme_support('resource-simplify-images');`

* **Disable Comments; hide Comments menu item**<br>
  `add_theme_support('resource-disable-comments');`

* **Hide Posts menu item; hide Categories & Tags**<br>
  `add_theme_support('resource-remove-posts');`

* **Remove Menu Items**<br>
  `add_theme_support('resource-remove-menu-items');`

* **Remove Widgets**<br>
  `add_theme_support('resource-remove-widgets');`

* **Clean Customizer**<br>
  `add_theme_support('resource-clean-customizer');`

* **Clean Dashboard and add Site Information metabox**<br>
  `add_theme_support('resource-clean-dashboard');`

* **Change 'Posts' to 'News' (only if enabled)**<br>
  `add_theme_support('resource-posts-to-news');`

* **Gravity Forms modifications (force JS to footer, hide spinner)**<br>
  `add_theme_support('resource-gravity-forms');`

* **SVG Support**<br>
  `add_theme_support('resource-svg');`

* **Define directory to save JSON ACF fields**<br>
  `add_theme_support('resource-advanced-custom-fields');`

* **Bootstrap 4 compatible nav walker**<br>
  `add_theme_support('resource-nav-walker');`

And in a format you can copy & paste into your theme:
```php
/**
 * Enable features from Resource Config_WP when plugin is activated
 * @link https://github.com/ecruhling/config_wp/
 */
add_theme_support('resource-change-howdy');
add_theme_support('resource-change-footer');
add_theme_support('resource-seo-framework');
add_theme_support('resource-custom-login');
add_theme_support('resource-change-author');
add_theme_support('resource-change-menu-order');
add_theme_support('resource-simplify-images');
add_theme_support('resource-disable-comments');
add_theme_support('resource-remove-posts');
add_theme_support('resource-remove-menu-items');
add_theme_support('resource-remove-widgets');
add_theme_support('resource-clean-customizer');
add_theme_support('resource-clean-dashboard');
add_theme_support('resource-posts-to-news');
add_theme_support('resource-gravity-forms');
add_theme_support('resource-svg');
add_theme_support('resource-advanced-custom-fields');
add_theme_support('resource-nav-walker');
```
