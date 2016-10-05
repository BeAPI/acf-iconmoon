<?php
/*
 Plugin Name: Advanced Custom Fields: Iconmoon
 Version: 0.2
 Plugin URI: http://www.beapi.fr
 Description: Add iconmoon selector
 Author: BE API Technical team
 Author URI: http://www.beapi.fr
 Domain Path: languages
 Text Domain: bea-acf-iconmoon
 
 ----
 
 Copyright 2016 BE API Technical team (human@beapi.fr)
 
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

add_action( 'init', 'bea_acf_field_iconmoon_init' );
function bea_acf_field_iconmoon_init() {
	// Load translations
	load_plugin_textdomain( 'bea-acf-iconmoon', false, plugin_dir_path( __FILE__ ) . 'languages' );
}
