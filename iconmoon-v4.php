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
		$this->label    = __( 'Icon selector', 'bea-acf-iconmoon' );
		$this->category = __( "Basic", 'acf' ); // Basic, Content, Choice, etc
		$this->defaults = array( // add default here to merge into your field.
			// This makes life easy when creating the field options as you don't need to use any if( isset('') ) logic. eg:
			//'preview_size' => 'thumbnail'
		);


		// do not delete!
		parent::__construct();


		// settings
		$this->settings = array( 'path'    => apply_filters( 'acf/helpers/get_path', __FILE__ ),
								 'dir'     => apply_filters( 'acf/helpers/get_dir', __FILE__ ),
								 'version' => '1.0.0' );

	}

	public function parse_css() {
		$filepath = apply_filters( 'bea_iconmoon_filepath', $this->settings['path'].'/assets/css/style.css' );
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

	function input_admin_enqueue_scripts() {
		// The suffix
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG === true ? '' : '.min' ;

		// Scripts
		wp_register_script( 'select2', $this->settings['dir'] . 'assets/js/lib/select2/select2.min.js', array( 'jquery' ), true );
		wp_register_script( 'acf-input-iconmoon', $this->settings['dir'] . 'assets/js/input'.$suffix.'.js', array( 'jquery', 'select2' ), $this->settings['version'], false );

		// Styles
		wp_register_style( 'select2', $this->settings['dir'] . 'assets/js/lib/select2/select2.css' );

		$file_url = apply_filters( 'bea_iconmoon_fileurl', $this->settings['dir'].'/assets/css/style'.$suffix.'.css' );
		wp_register_style( 'acf-input-iconmoon-s', $file_url, array( 'select2' ), $this->settings['version'] );

		wp_localize_script( 'acf-input-iconmoon', 'bea_acf_iconmon', $this->parse_css() );

		// Enqueuing
		wp_enqueue_style( 'acf-input-iconmoon-s' );
		wp_enqueue_script( 'acf-input-iconmoon' );

		add_action( 'admin_head', array( $this, 'display_css' ) );
	}

	/**
	 * Display the css based on the vars given for dynamic fonts url
	 */
	public function display_css() {
		$fonts = apply_filters( 'bea_iconmoon_fonts', array(
			'eot' => $this->settings['dir'].'assets/css/fonts/icomoon.eot?-v5pt2y',
			'woff' => $this->settings['dir'].'assets/css/fonts/icomoon.woff?-v5pt2y',
			'ttf' => $this->settings['dir'].'assets/css/fonts/icomoon.ttf?-v5pt2y',
			'svg' => $this->settings['dir'].'assets/css/fonts/icomoon.svg?-v5pt2y#icomoon',
		) );
		$font_name = apply_filters( 'bea_iconmoon_font_family_name', 'icomoon' );
		?>
		<style type="text/css" >
			@font-face {
				font-family: '<?php echo esc_attr( $font_name ); ?>';
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

	function create_field( $field ) {
		// create Field HTML
		?>
		<input class="widefat bea-acf-<?php echo esc_attr( $field['class'] ); ?>" value="<?php echo esc_attr( $field['value'] ); ?>" name="<?php echo esc_attr( $field['name'] ); ?>" />
		<script>bea_acf_iconmoon_select2()</script>
		<?php
	}
}


// create field
new acf_field_iconmoon();