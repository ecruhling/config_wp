# Resource Config_WP

## Modules

* **Change 'Howdy' to 'Greetings'**<br>
  `add_theme_support('resource-change-howdy');`

* **Change footer text to cite Resource**<br>
  `add_theme_support('resource-change-footer');`

* **Move SEO Framework metabox to bottom & remove head comment**<br>
  `add_theme_support('resource-seo-framework');`

* **Add custom login page**<br>
  `add_theme_support('resource-custom-login');`

* **Change some settings for author pages / disables author archives**<br>
  `add_theme_support('resource-change-author');`

* **Change order of menu items, Posts, Pages, Media**<br>
  `add_theme_support('resource-change-menu-order');`

* **Simplify image use: don't add links to images; disable attachment pages**<br>
  `add_theme_support('resource-simplify-images');`

* **Disable comments; remove Comments menu**<br>
  `add_theme_support('resource-disable-comments');`

* **Hide Posts menu item; also Categories & Tags**<br>
  `add_theme_support('resource-remove-posts');`

* **Remove Menu Items**<br>
  `add_theme_support('resource-remove-menu-items');`

* **Remove Menu Items**<br>
  `add_theme_support('resource-remove-widgets');`

* **Clean Dashboard and add Site Information**<br>
  `add_theme_support('resource-clean-dashboard');`

* **Clean Customizer**<br>
  `add_theme_support('resource-clean-customizer');`

And in a format you can copy & paste into your theme:
```php
/**
 * Enable features from Resource Config_WP when plugin is activated
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
add_theme_support('resource-clean-dashboard');
add_theme_support('resource-clean-customizer');
```
