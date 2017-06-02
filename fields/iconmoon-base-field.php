<?php

class acf_field_iconmoon_base extends acf_field {

	var $defaults;

	function __construct() {
		// vars
		$this->name     = 'iconmoon';
		$this->label    = __( 'Icon selector', 'bea-acf-iconmoon' );
		$this->category = __( 'Basic', 'acf' );
		$this->defaults = array(
			'allow_clear' => 0,
		);

		// do not delete!
		parent::__construct();
	}

	/**
	 * Extract icons from icomoon stylesheet.
	 *
	 * @since 0.1
	 *
	 * @return array|bool
	 */
	public function parse_css() {

		$filepath = ACF_ICOMOON_DIR . 'assets/css/style.css';
		/**
		 * The path to the icomoon stylesheet.
		 *
		 * @since 0.1
		 *
		 * @param string $filepath default path
		 */
		$filepath = apply_filters( 'bea_iconmoon_filepath', $filepath );
		if ( ! file_exists( $filepath ) ) {
			return array();
		}

		// First try to load icons from the cache
		$cache_key = 'bea_icon_moon_' . md5( $filepath );
		$out       = wp_cache_get( $cache_key );
		if ( ! empty( $out ) ) {
			return $out;
		}

		// If not extract them from the CSS file
		$contents = file_get_contents( $filepath );

		preg_match_all( '#.icon-(.*):before#', $contents, $css );
		array_shift( $css );


		foreach ( $css[0] as $cs ) {
			$out[] = array( 'id' => $cs, 'text' => $cs );
		}

		// Cache 24 hours
		wp_cache_set( $cache_key, $out, '', HOUR_IN_SECONDS * 24 );

		return $out;
	}

	/**
	 * Display the css based on the vars given for dynamic fonts url.
	 *
	 * @since 0.1
	 */
	public function display_css() {

		$base_url = ACF_ICOMOON_URL;

		$font_name = 'icomoon';
		/**
		 * The font's name
		 *
		 * @since 0.1
		 *
		 * @param string $font_name the default font's name
		 */
		$font_name = apply_filters( 'bea_iconmoon_font_family_name', $font_name );

		$font_urls = array(
			'eot'  => $base_url . 'assets/css/fonts/icomoon.eot?-v5pt2y',
			'woff' => $base_url . 'assets/css/fonts/icomoon.woff?-v5pt2y',
			'ttf'  => $base_url . 'assets/css/fonts/icomoon.ttf?-v5pt2y',
			'svg'  => $base_url . 'assets/css/fonts/icomoon.svg?-v5pt2y#icomoon',
		);
		/**
		 * The font's files URLs
		 *
		 * @since 0.1
		 *
		 * @param array $font_urls the default font's file URLs
		 */
		$font_urls = apply_filters( 'bea_iconmoon_fonts', $font_urls );

		?>
        <style type="text/css">
            @font-face {
                font-family: '<?php echo esc_attr( $font_name ); ?>';
                <?php if ( ! empty( $font_urls['eot'] ) ) : ?>
				src: url('<?php echo esc_url( $font_urls['eot'] ); ?>');
				<?php endif; ?>

				<?php if ( ! empty( $font_urls['eot'] ) ) : ?>
				src: url('<?php echo esc_url( $font_urls['eot'] ); ?>') format('embedded-opentype');
				<?php endif; ?>

				<?php if ( ! empty( $font_urls['woff'] ) ) : ?>
				src: url('<?php echo esc_url( $font_urls['woff'] ); ?>') format('woff');
				<?php endif; ?>

				<?php if ( ! empty( $font_urls['ttf'] ) ) : ?>
				src: url('<?php echo esc_url( $font_urls['ttf'] ); ?>') format('truetype');
				<?php endif; ?>

				<?php if ( ! empty( $font_urls['svg'] ) ) : ?>
				src: url('<?php echo esc_url( $font_urls['svg'] ); ?>') format('svg');
				<?php endif; ?>
                font-weight: normal;
                font-style: normal;
            }
        </style>
		<?php
	}

	/**
	 * Enqueue assets for the Icomoon field in admin
	 *
	 * @since 0.1
	 */
	function input_admin_enqueue_scripts() {

		// The suffix
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG === true ? '' : '.min';

		// Scripts
		wp_register_script(
			'select2',
			ACF_ICOMOON_URL . 'assets/js/select2/select2' . $suffix . '.js',
			array( 'jquery' ),
			'3.5.2'
		);

		wp_register_script(
			'acf-input-iconmoon',
			ACF_ICOMOON_URL . 'assets/js/input' . $suffix . '.js',
			array( 'jquery', 'select2' ),
			ACF_ICOMOON_VER
		);

		// Localizing the script
		wp_localize_script( 'acf-input-iconmoon', 'bea_acf_iconmon', $this->parse_css() );

		// Styles
		wp_register_style(
			'select2',
			ACF_ICOMOON_URL . 'assets/js/select2/select2.css',
			array(),
			'3.5.2'
		);

		$css_file = ACF_ICOMOON_URL . 'assets/css/style' . $suffix . '.css';
		/**
		 * The icomoon stylesheet's URL.
		 *
		 * @since 0.1
		 *
		 * @param string $css_file the default icomoon stylesheet's URL
		 */
		$css_file = apply_filters( 'bea_iconmoon_fileurl', $css_file );
		wp_register_style(
			'acf-input-iconmoon',
			$css_file,
			array( 'select2' ),
			ACF_ICOMOON_VER
		);

		// Enqueuing
		wp_enqueue_style( 'acf-input-iconmoon' );
		wp_enqueue_script( 'acf-input-iconmoon' );
	}

	/**
	 * Display Icomoon style in head.
	 *
	 * @since 0.1
	 */
	public function input_admin_head() {
		$this->display_css();
	}
}
