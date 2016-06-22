<?php

class acf_field_iconmoon extends acf_field {
	// vars
	var $settings, // will hold info such as dir / path
		$defaults; // will hold default field options


	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/

	function __construct() {
		// vars
		$this->name     = 'iconmoon';
		$this->label    = __( 'Selecteur d\'icones' );
		$this->category = __( "Basic", 'acf' ); // Basic, Content, Choice, etc
		$this->defaults = array( // add default here to merge into your field.
			// This makes life easy when creating the field options as you don't need to use any if( isset('') ) logic. eg:
			//'preview_size' => 'thumbnail'
		);

		$this->defaults = array();

		// do not delete!
		parent::__construct();
	}

	/**
	 * @return array|bool|mixed
	 * @author Nicolas Juen
	 */
	public function parse_css() {
		// Url to load
		$path = plugin_dir_path( __FILE__ );

		$filepath = apply_filters( 'bea_iconmoon_filepath', $path.'/assets/css/style.css' );
		$cache_key = 'bea_icon_moon_'.md5( $filepath );
		$out = wp_cache_get( $cache_key, false, array() );

		if( !empty( $out ) ) {
			return $out;
		}

		if( !file_exists( $filepath ) ) {
			return array();
		}

		$contents = file_get_contents( $filepath );

		preg_match_all( "#.icon-(.*):before#", $contents, $css );
		array_shift( $css );


		foreach( $css[0] as $cs ) {
			$out[] = array( 'id' => $cs, 'text' => $cs );
		}

		// Cache 8 hours
		wp_cache_set( $cache_key, $out, '', HOUR_IN_SECONDS * 8 );

		return $out;
	}

	/**
	 * @author Nicolas Juen
	 */
	function input_admin_enqueue_scripts() {

		// Url to load
		$url = plugin_dir_url( __FILE__ );

		// The suffix
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG === true ? '' : '.min' ;

		// Scripts
		wp_register_script( 'acf-input-iconmoon', $url . 'assets/js/input'.$suffix.'.js', array( 'jquery', 'select2' ), '1.0', false );

		// Styles
		wp_register_style( 'acf-input-iconmoon-s', apply_filters( 'bea_iconmoon_fileurl', $url.'/assets/css/style'.$suffix.'.css' ) );

		// Localizing the scripts
		wp_localize_script( 'acf-input-iconmoon', 'bea_acf_iconmon', $this->parse_css() );

		// Enqueuing
		wp_enqueue_style( 'acf-input-iconmoon-s' );
		wp_enqueue_script( 'acf-input-iconmoon' );
	}

	public function input_admin_head() {
		$this->display_css();
	}

	/**
	 * Display the css based on the vars given for dynamic fonts url
	 */
	public function display_css() {
		// Url to load
		$url = plugin_dir_url( __FILE__ );

		$fonts = apply_filters( 'bea_iconmoon_fonts', array(
			'eot' => $url.'assets/css/fonts/icomoon.eot?-v5pt2y',
			'woff' => $url.'assets/css/fonts/icomoon.woff?-v5pt2y',
			'ttf' => $url.'assets/css/fonts/icomoon.ttf?-v5pt2y',
			'svg' => $url.'assets/css/fonts/icomoon.svg?-v5pt2y#icomoon',
		) );

		?>
		<style type="text/css" >
			@font-face {
				font-family: 'icomoon';
				src:url('<?php echo esc_url( $fonts['eot'] ); ?>');
				src:url('<?php echo esc_url( $fonts['eot'] ); ?>') format('embedded-opentype'),
				url('<?php echo esc_url( $fonts['woff'] ); ?>') format('woff'),
				url('<?php echo esc_url( $fonts['ttf'] ); ?>') format('truetype'),
				url('<?php echo esc_url( $fonts['svg'] ); ?>') format('svg');
				font-weight: normal;
				font-style: normal;
			}
		</style>
		<?php
	}



	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/

	function create_options( $field ) {

	}


	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function render_field( $field ) {
		// create Field HTML
		?>
		<input class="widefat bea-acf-<?php echo esc_attr( $field['type'] ); ?>" value="<?php echo esc_attr( $field['value'] ); ?>" name="<?php echo esc_attr( $field['name'] ); ?>" />
		<?php
	}
}


// create field
new acf_field_iconmoon();