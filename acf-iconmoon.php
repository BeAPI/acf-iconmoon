<?php
/*
 Plugin Name: Advanced Custom Fields: Iconmoon
 Version: 0.5
 Plugin URI: http://www.beapi.fr
 Description: Add icomoon selector
 Author: BE API Technical team
 Author URI: http://www.beapi.fr
 Domain Path: languages
 Text Domain: bea-acf-iconmoon

 ----

 Copyright 2022 BE API Technical team (human@beapi.fr)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

define( 'ACF_ICOMOON_VER', '0.5' );
define( 'ACF_ICOMOON_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_ICOMOON_DIR', plugin_dir_path( __FILE__ ) );

class acf_field_iconmoon_plugin {

	/**
	 * Constructor.
	 *
	 * Load plugin's translation and register icomoon fields.
	 *
	 * @since 0.1
	 */
	function __construct() {

		add_action( 'init', array( __CLASS__, 'load_translation' ), 1 );

		// Register ACF fields
		add_action( 'acf/register_fields', array( __CLASS__, 'register_field_v4' ) );
		add_action( 'acf/include_field_types', array( __CLASS__, 'register_field_v5' ) );
	}

	/**
	 * Load plugin translation.
	 *
	 * @since 0.1
	 */
	public static function load_translation() {
		load_plugin_textdomain(
			'bea-acf-iconmoon',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);
	}

	/**
	 * Register Icomoon field for ACF v4.
	 *
	 * @since 0.1
	 */
	public static function register_field_v4() {
		include_once( ACF_ICOMOON_DIR . 'fields/iconmoon-base-field.php' );
		include_once( ACF_ICOMOON_DIR . 'fields/iconmoon-v4.php' );
	}

	/**
	 * Register Icomoon field for ACF v5.
	 *
	 * @since 0.1
	 */
	public static function register_field_v5() {

		$enqueue_select2 = acf_get_setting( 'enqueue_select2' );
		if ( is_null( $enqueue_select2 ) ) {
			acf_update_setting( 'enqueue_select2', true );
		}

		$select2_version = acf_get_setting( 'select2_version' );
		if ( is_null( $select2_version ) ) {
			acf_update_setting( 'select2_version', 3 );
		}

		include_once( ACF_ICOMOON_DIR . 'fields/iconmoon-base-field.php' );
		include_once( ACF_ICOMOON_DIR . 'fields/iconmoon-v5.php' );
	}
}

/**
 * Init plugin.
 *
 * @since 0.1
 */
function bea_acf_field_iconmoon_load() {
	new acf_field_iconmoon_plugin();
}
add_action( 'plugins_loaded', 'bea_acf_field_iconmoon_load' );
