<?php
/**
 * My Account Customizer for WooCommerce - Fields Class
 *
 * @version 2.0.0
 * @since   1.1.0
 *
 * @author  Algoritmika Ltd
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_MAC_Fields' ) ) :

class Alg_WC_MAC_Fields {

	/**
	 * fields.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	public $fields;

	/**
	 * Constructor.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 *
	 * @todo    (dev) move to `init` hook?
	 * @todo    (feature) `is_admin`: option to NOT show fields for the current user (i.e., show for admin only)
	 */
	function __construct() {
		if ( 'yes' === get_option( 'alg_wc_mac_fields_section_enabled', 'no' ) ) {

			if ( ! is_admin() ) {

				add_action(
					'woocommerce_edit_account_form',
					array( $this, 'edit_account_form' )
				);

				add_action(
					'woocommerce_save_account_details',
					array( $this, 'save_account_details' )
				);

				add_filter(
					'woocommerce_save_account_details_required_fields',
					array( $this, 'save_account_details_required_fields' )
				);

			} else {

				add_action(
					'show_user_profile',
					array( $this, 'admin_show_extra_profile_fields' ),
					PHP_INT_MAX
				);

				add_action(
					'edit_user_profile',
					array( $this, 'admin_show_extra_profile_fields' ),
					PHP_INT_MAX
				);

				add_action(
					'personal_options_update',
					array( $this, 'admin_update_profile_fields' )
				);

				add_action(
					'edit_user_profile_update',
					array( $this, 'admin_update_profile_fields' )
				);

				add_action(
					'user_profile_update_errors',
					array( $this, 'admin_user_profile_update_errors' ),
					PHP_INT_MAX,
					3
				);

			}

		}
	}

	/**
	 * get_fields.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 *
	 * @todo    (dev) run `do_shortcode()` later, e.g., in `get_field_html()`?
	 * @todo    (feature) visibility: customer/admin
	 * @todo    (feature) type: textarea
	 * @todo    (feature) type: (maybe) date/time picker
	 * @todo    (feature) type: select/radio
	 * @todo    (feature) type: checkbox
	 * @todo    (feature) type: file
	 * @todo    (feature) recheck all unused "types": 'button', 'checkbox', 'datetime-local', 'file', 'hidden', 'image', 'radio', 'reset', 'search', 'submit'
	 * @todo    (feature) default value
	 * @todo    (feature) placeholder
	 * @todo    (feature) class
	 * @todo    (feature) style
	 * @todo    (feature) ordering
	 */
	function get_fields() {
		if ( isset( $this->fields ) ) {
			return $this->fields;
		}
		$this->fields = array();
		$options      = array();
		$options_id   = array(
			'enabled',
			'required',
			'title',
			'desc',
			'type',
		);
		foreach ( $options_id as $option_id ) {
			$options[ $option_id ] = get_option( 'alg_wc_mac_fields_' . $option_id, array() );
		}
		for ( $i = 1; $i <= get_option( 'alg_wc_mac_fields_total', 1 ); $i++ ) {
			if ( 'yes' === ( isset( $options['enabled'][ $i ] ) ? $options['enabled'][ $i ] : 'yes' ) ) {
				$this->fields[ 'alg_wc_mac_' . $i ] = array(
					'required' => ( $options['required'][ $i ] ?? 'no' ),
					'title'    => (
						isset( $options['title'][ $i ] ) ?
						do_shortcode( $options['title'][ $i ] ) :
						sprintf(
							/* Translators: %s: Field ID. */
							__( 'Field %s', 'my-account-customizer-for-woocommerce' ),
							'#' . $i )
						),
					'desc'     => (
						isset( $options['desc'][ $i ] ) ?
						do_shortcode( $options['desc'][ $i ] ) :
						''
					),
					'type'     => ( $options['type'][ $i ] ?? 'text' ),
				);
			}
		}
		return $this->fields;
	}

	/**
	 * do_save_field_type.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	function do_save_field_type( $field_type ) {
		return ( ! in_array( $field_type, array( 'title', 'gravatar' ) ) );
	}

	/**
	 * get_field_html.
	 *
	 * @version 2.0.0
	 * @since   1.1.0
	 *
	 * @todo    (dev) `is_admin`: output `title`
	 * @todo    (feature) add "after the field" & "before the field" options (HTML/shortcodes)
	 * @todo    (feature) make "clear div" optional
	 */
	function get_field_html( $user_id, $field_id, $field_data, $is_admin ) {

		// "Title" field
		if ( 'title' === $field_data['type'] ) {
			return (
				$is_admin ?
				'' :
				(
					'<h3>' . esc_html( $field_data['title'] ) . '</h3>' .
					(
						'' != $field_data['desc'] ?
						'<p><em>' . $field_data['desc'] . '</em></p>' :
						''
					)
				)
			);
		}

		// All other fields
		$value    = (
			$this->do_save_field_type( $field_data['type'] ) ?
			esc_attr( get_user_meta( $user_id, $field_id, true ) ) :
			false
		);
		$required = (
			(
				$this->do_save_field_type( $field_data['type'] ) &&
				'yes' === $field_data['required']
			) ?
			(
				$is_admin ?
				' <span class="description">' .
					__( '(required)', 'my-account-customizer-for-woocommerce' ) .
				'</span>' :
				'&nbsp;<span class="required">*</span>'
			) :
			''
		);
		$label    = '<label for="' . $field_id . '">' .
			esc_html( $field_data['title'] ) . $required .
		'</label>';
		$desc     = (
			'' != $field_data['desc'] ?
			(
				$is_admin ?
				'<p class="description">' . $field_data['desc'] . '</p>' :
				' <span><em>' . $field_data['desc'] . '</em></span>'
			) :
			''
		);
		switch ( $field_data['type'] ) {
			case 'gravatar':
				$input = get_avatar( $user_id );
				break;
			default:
				$input = '<input' .
						' type="'  . $field_data['type'] . '"' .
						' class="' . (
							$is_admin ?
							'regular-' . $field_data['type'] :
							'woocommerce-Input woocommerce-Input--' . $field_data['type'] . ' input-' . $field_data['type']
						) . '"' .
						' name="'  . $field_id . '"' .
						' id="'    . $field_id . '"' .
						' value="' . $value . '"' .
					' />';
				break;
		}
		return (
			$is_admin ?
			'<tr><th>' . $label . '</th><td>' . $input . $desc . '</td></tr>' :
			'<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">' .
				$label . $input . $desc .
			'</p>' . '<div class="clear"></div>'
		);

	}

	/**
	 * get_allowed_html.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function get_allowed_html() {
		$allowed_html = array(
			'input' => array(
				'type'  => true,
				'id'    => true,
				'name'  => true,
				'class' => true,
				'style' => true,
				'value' => true,
			),
			'img' => array(
				'alt'      => true,
				'src'      => true,
				'class'    => true,
				'height'   => true,
				'width'    => true,
				'loading'  => true,
				'srcset'   => true,
				'decoding' => true,
				'value'    => true,
			),
		);
		return array_merge(
			wp_kses_allowed_html( 'post' ),
			$allowed_html
		);
	}

	/**
	 * edit_account_form.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function edit_account_form() {

		$user_id = get_current_user_id();
		$html    = '';

		foreach ( $this->get_fields() as $field_id => $field_data ) {
			$html .= $this->get_field_html( $user_id, $field_id, $field_data, false );
		}

		echo wp_kses( $html, $this->get_allowed_html() );

		wp_nonce_field(
			'alg_wc_mac_profile_fields',
			'_alg_wc_mac_nonce_profile_fields'
		);

	}

	/**
	 * save_account_details.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function save_account_details( $user_id ) {

		if (
			! isset( $_POST['_alg_wc_mac_nonce_profile_fields'] ) ||
			! wp_verify_nonce(
				sanitize_text_field( wp_unslash( $_POST['_alg_wc_mac_nonce_profile_fields'] ) ),
				'alg_wc_mac_profile_fields'
			)
		) {
			wp_die( esc_html__( 'Invalid nonce.', 'my-account-customizer-for-woocommerce' ) );
		}

		foreach ( $this->get_fields() as $field_id => $field_data ) {
			if ( ! $this->do_save_field_type( $field_data['type'] ) ) {
				continue;
			}
			$value = (
				isset( $_POST[ $field_id ] ) ?
				wc_clean( wp_unslash( $_POST[ $field_id ] ) ) : // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
				''
			);
			update_user_meta( $user_id, $field_id, $value );
		}

	}

	/**
	 * save_account_details_required_fields.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 */
	function save_account_details_required_fields( $required_fields ) {
		foreach ( $this->get_fields() as $field_id => $field_data ) {
			if ( ! $this->do_save_field_type( $field_data['type'] ) ) {
				continue;
			}
			if ( 'yes' === $field_data['required'] ) {
				$required_fields[ $field_id ] = $field_data['title'];
			}
		}
		return $required_fields;
	}

	/**
	 * admin_check_current_user.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 */
	function admin_check_current_user( $user_id ) {
		return (
			current_user_can( 'manage_woocommerce' ) &&
			current_user_can( 'edit_user', $user_id )
		);
	}

	/**
	 * admin_show_extra_profile_fields.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 *
	 * @todo    (dev) `do_shortcode()`
	 * @todo    (feature) optional description in header
	 */
	function admin_show_extra_profile_fields( $user ) {

		if ( ! $this->admin_check_current_user( $user->ID ) ) {
			return false;
		}

		$user_id = $user->ID;
		$html    = '';

		foreach ( $this->get_fields() as $field_id => $field_data ) {
			$html .= $this->get_field_html( $user_id, $field_id, $field_data, true );
		}

		if ( ! empty( $html ) ) {
			echo (
				'<h2>' .
					wp_kses_post(
						get_option(
							'alg_wc_mac_fields_backend_section_title',
							__( 'Extra Profile Fields', 'my-account-customizer-for-woocommerce' )
						)
					) .
				'</h2>' .
				'<table class="form-table"><tbody>' .
					wp_kses( $html, $this->get_allowed_html() ) .
				'</tbody></table>'
			);
		}

		wp_nonce_field(
			'alg_wc_mac_admin_profile_fields',
			'_alg_wc_mac_nonce_admin_profile_fields'
		);

	}

	/**
	 * admin_update_profile_fields.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function admin_update_profile_fields( $user_id ) {

		if ( ! $this->admin_check_current_user( $user_id ) ) {
			return false;
		}

		if (
			! isset( $_POST['_alg_wc_mac_nonce_admin_profile_fields'] ) ||
			! wp_verify_nonce(
				sanitize_text_field( wp_unslash( $_POST['_alg_wc_mac_nonce_admin_profile_fields'] ) ),
				'alg_wc_mac_admin_profile_fields'
			)
		) {
			wp_die( esc_html__( 'Invalid nonce.', 'my-account-customizer-for-woocommerce' ) );
		}

		foreach ( $this->get_fields() as $field_id => $field_data ) {
			if ( ! $this->do_save_field_type( $field_data['type'] ) ) {
				continue;
			}
			$value = (
				isset( $_POST[ $field_id ] ) ?
				wc_clean( wp_unslash( $_POST[ $field_id ] ) ) : // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
				''
			);
			if ( '' !== $value || 'no' === $field_data['required'] ) {
				update_user_meta( $user_id, $field_id, $value );
			}
		}

	}

	/**
	 * admin_user_profile_update_errors.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function admin_user_profile_update_errors( $errors, $update, $user ) {

		if ( ! $update ) {
			return;
		}

		if (
			! isset( $_POST['_alg_wc_mac_nonce_admin_profile_fields'] ) ||
			! wp_verify_nonce(
				sanitize_text_field( wp_unslash( $_POST['_alg_wc_mac_nonce_admin_profile_fields'] ) ),
				'alg_wc_mac_admin_profile_fields'
			)
		) {
			wp_die( esc_html__( 'Invalid nonce.', 'my-account-customizer-for-woocommerce' ) );
		}

		foreach ( $this->get_fields() as $field_id => $field_data ) {
			if ( ! $this->do_save_field_type( $field_data['type'] ) ) {
				continue;
			}
			if ( 'yes' === $field_data['required'] ) {
				if ( ! isset( $_POST[ $field_id ] ) || '' === $_POST[ $field_id ] ) {
					$errors->add(
						'empty_' . $field_id,
						sprintf(
							/* Translators: %s: Field title. */
							__( '<strong>ERROR</strong>: "%s" is required.', 'my-account-customizer-for-woocommerce' ),
							$field_data['title']
						)
					);
				}
			}
		}

	}

}

endif;

return new Alg_WC_MAC_Fields();
