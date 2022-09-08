# Advanced Custom Fields: Iconmoon #

## Description ##

This enhance ACF with a field icons. Add a field type selector to include your great font icon and returns class icon.
One activated you'll be able to use a custom ACF field type which is an icon selector

## Important to know ##

In case you want to include this small plugin to your project running composer you can add this line to your composer.json :

```json
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/BeAPI/acf-iconmoon"
    }
  ]
```

then run the command :

```shell
composer require bea/acf-iconmoon
```

## Tips ##

### Using this with your own font icon in your own theme ###

Font family name, font files dir path and font files URL are filterable.

```php
/**
 * Update icon file css path.
 *
 * @return string
 */
function bea_override_acf_iconmoon_filepath() {
	return get_stylesheet_directory() . '/assets/css/icons.css';
}
add_filter( 'bea_iconmoon_filepath', 'bea_override_acf_iconmoon_filepath' );

/**
 * Update icon file css url
 *
 * @return string
 */
function bea_override_acf_iconmoon_fileurl() {
	return get_stylesheet_directory_uri() . '/assets/css/icons.css';
}
add_filter( 'bea_iconmoon_fileurl', 'bea_override_acf_iconmoon_fileurl' );

/**
 * Update icon files.
 *
 * @return array
 */
function bea_override_acf_iconmoon_fonts() {
	return array(
		'eot' => get_stylesheet_directory_uri() . '/assets/fonts/bea_icons.eot',
		'woff' => get_stylesheet_directory_uri() . '/assets/fonts/bea_icons.woff',
		'ttf' => get_stylesheet_directory_uri() . '/assets/fonts/bea_icons.ttf',
		'svg' => get_stylesheet_directory_uri() . '/assets/fonts/bea_icons.svg',
	);
}
add_filter( 'bea_iconmoon_fonts', 'bea_override_acf_iconmoon_fonts' );

/**
 * font family for theme
 */
function bea_override_acf_iconmoon_font_family() {
    return 'my_custom_font_family_name';
}
add_filter( 'bea_iconmoon_font_family_name', 'bea_override_acf_iconmoon_font_family' );
```

## Changelog ##

### 0.5 (September 9, 2022)
* Update regex use for extracting icon's name from CSS file 

### 0.4 (September 21, 2017)
* Add support for Select2 v4

### 0.3 (December 22, 2016)
* Refactor plugin
* Add support for clear button

### 0.2 (June 28, 2016)
* lang, gitignore + readme

### 0.1 (February 12, 2016)
* initial commit
