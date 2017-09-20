<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class acf_field_iconmoon extends acf_field_iconmoon_base {

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
		$key = $field['name'];
		?>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php _e( 'Display clear button?', 'bea-acf-iconmoon' ); ?></label>
                <p><?php _e( 'Whether or not a clear button is displayed when the select box has a selection.', 'bea-acf-iconmoon' ) ?></p>
            </td>
            <td>
				<?php

				do_action( 'acf/create_field',
					array(
						'type'  => 'true_false',
						'name'  => 'fields[' . $key . '][allow_clear]',
						'value' => $field['allow_clear'],
					) );

				?>
            </td>
        </tr>
		<?php
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
        <input class="widefat bea-acf-<?php echo esc_attr( $field['class'] ); ?>"
               value="<?php echo esc_attr( $field['value'] ); ?>"
               name="<?php echo esc_attr( $field['name'] ); ?>"
               data-placeholder="<?php _e( 'Select an icon', 'bea-acf-iconmoon' ); ?>"
               data-allow-clear="<?php echo esc_attr( $field['allow_clear'] ) ?>"/>
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

		if ( ! wp_script_is( 'select2', 'registered' ) ) {
			wp_register_script(
				'select2',
				ACF_ICOMOON_URL . 'assets/js/select2/select2' . $suffix . '.js',
				array( 'jquery' ),
				'3.5.2'
			);

			wp_register_style(
				'select2',
				ACF_ICOMOON_URL . 'assets/js/select2/select2.css',
				array(),
				'3.5.2'
			);
		}

		// Scripts
		wp_register_script(
			'acf-input-iconmoon',
			ACF_ICOMOON_URL . 'assets/js/input' . $suffix . '.js',
			array( 'select2' ),
			ACF_ICOMOON_VER
		);

		// Localizing the script
		wp_localize_script( 'acf-input-iconmoon', 'bea_acf_iconmon', $this->parse_css() );

		// Styles
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
}

// create field
new acf_field_iconmoon();