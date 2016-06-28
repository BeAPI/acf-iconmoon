<?php
/*
Plugin Name: Advanced Custom Fields: Iconmoon
Description: Add iconmoon selector
Version: 0.2
Author: Be API
Author URI: www.beapi.fr
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Domain Path: languages
Text Domain: bea-acf-iconmoon
*/


class acf_field_iconmoon_plugin {
	/**
	*  Construct
	*
	*  @description:
	*  @since: 3.6
	*  @created: 1/04/13
	 * @author Nicolas Juen
	*/

	function __construct() {
		// version 4+
		add_action( 'acf/register_fields', array( __CLASS__, 'register_field_v4' ) );
		add_action( 'acf/include_field_types', array( __CLASS__, 'register_field_v5' ) );
	}

	/**
	*  register_fields
	*
	*  @description:
	*  @since: 3.6
	*  @created: 1/04/13
	 * @author Nicolas Juen
	*/
	public static function register_field_v4() {
		include_once( 'iconmoon-v4.php' );
	}

	/**
	 *  register_fields
	 *
	 *  @description:
	 *  @since: 3.6
	 *  @created: 1/04/13
	 * @author Nicolas Juen
	 */
	public static function register_field_v5() {
		include_once( 'iconmoon-v5.php' );
	}

}

add_action( 'plugins_loaded', 'bea_acf_field_iconmoon_load' );
function bea_acf_field_iconmoon_load() {
	new acf_field_iconmoon_plugin();
}

add_action( 'init', 'acf_field_iconmoon_init' );
function bea_acf_field_iconmoon_init() {
	// Load translations
	load_plugin_textdomain( 'bea-acf-iconmoon', false, plugin_dir_path( __FILE__ ) . 'languages' );
}