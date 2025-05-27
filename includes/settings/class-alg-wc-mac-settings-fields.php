<?php
/**
 * My Account Customizer for WooCommerce - Fields Section Settings
 *
 * @version 2.0.0
 * @since   1.1.0
 *
 * @author  Algoritmika Ltd
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_MAC_Settings_Fields' ) ) :

class Alg_WC_MAC_Settings_Fields extends Alg_WC_MAC_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	function __construct() {
		$this->id   = 'fields';
		$this->desc = __( 'Fields', 'my-account-customizer-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 2.0.0
	 * @since   1.1.0
	 *
	 * @todo    (desc) Notes: move "Not applicable to the ..."
	 */
	function get_settings() {

		$fields_settings = array(
			array(
				'title'             => __( 'Fields Options', 'my-account-customizer-for-woocommerce' ),
				'desc'              => __( 'Adds custom fields to the "My account > Account details" tab in frontend, and to the user profile page in backend.', 'my-account-customizer-for-woocommerce' ),
				'type'              => 'title',
				'id'                => 'alg_wc_mac_fields_options',
			),
			array(
				'title'             => __( 'Fields', 'my-account-customizer-for-woocommerce' ),
				'desc'              => '<strong>' . __( 'Enable section', 'my-account-customizer-for-woocommerce' ) . '</strong>',
				'type'              => 'checkbox',
				'id'                => 'alg_wc_mac_fields_section_enabled',
				'default'           => 'no',
			),
			array(
				'title'             => __( 'Total fields', 'my-account-customizer-for-woocommerce' ),
				'desc_tip'          => $this->get_save_changes_desc(),
				'type'              => 'number',
				'id'                => 'alg_wc_mac_fields_total',
				'default'           => 1,
				'custom_attributes' => array( 'min' => 0 ),
			),
			array(
				'type'              => 'sectionend',
				'id'                => 'alg_wc_mac_fields_options',
			),
		);
		for ( $i = 1; $i <= get_option( 'alg_wc_mac_fields_total', 1 ); $i++ ) {
			$fields_settings = array_merge( $fields_settings, array(
				array(
					'title'    => sprintf(
						/* Translators: %s: Field ID. */
						__( 'Field %s', 'my-account-customizer-for-woocommerce' ),
						'#' . $i
					),
					'type'     => 'title',
					'id'       => "alg_wc_mac_fields[{$i}]",
				),
				array(
					'title'    => __( 'Enable/Disable', 'my-account-customizer-for-woocommerce' ),
					'desc'     => '<strong>' . sprintf(
						/* Translators: %s: Field ID. */
						__( 'Enable field %s', 'my-account-customizer-for-woocommerce' ),
						'#' . $i
					) . '</strong>',
					'id'       => "alg_wc_mac_fields_enabled[{$i}]",
					'default'  => 'yes',
					'type'     => 'checkbox',
				),
				array(
					'title'    => __( 'Required/Optional', 'my-account-customizer-for-woocommerce' ),
					'desc'     => __( 'Required', 'my-account-customizer-for-woocommerce' ),
					'desc_tip' => sprintf(
						/* Translators: %s: Type list. */
						__( 'Not applicable to the %s types.', 'my-account-customizer-for-woocommerce' ),
						'"' . implode( '", "', array(
							__( 'Title', 'my-account-customizer-for-woocommerce' ),
							__( 'Gravatar', 'my-account-customizer-for-woocommerce' ),
						) ) . '"'
					),
					'id'       => "alg_wc_mac_fields_required[{$i}]",
					'default'  => 'no',
					'type'     => 'checkbox',
				),
				array(
					'title'    => __( 'Title', 'my-account-customizer-for-woocommerce' ),
					'id'       => "alg_wc_mac_fields_title[{$i}]",
					'default'  => sprintf(
						/* Translators: %s: Field ID. */
						__( 'Field %s', 'my-account-customizer-for-woocommerce' ),
						'#' . $i
					),
					'type'     => 'text',
				),
				array(
					'title'    => __( 'Description', 'my-account-customizer-for-woocommerce' ),
					'id'       => "alg_wc_mac_fields_desc[{$i}]",
					'default'  => '',
					'type'     => 'textarea',
					'css'      => 'width:100%;',
				),
				array(
					'title'    => __( 'Type', 'my-account-customizer-for-woocommerce' ),
					'id'       => "alg_wc_mac_fields_type[{$i}]",
					'default'  => 'text',
					'type'     => 'select',
					'class'    => 'chosen_select',
					'options'  => array(
						'color'          => __( 'Color', 'my-account-customizer-for-woocommerce' ),
						'date'           => __( 'Date', 'my-account-customizer-for-woocommerce' ),
						'email'          => __( 'Email', 'my-account-customizer-for-woocommerce' ),
						'month'          => __( 'Month', 'my-account-customizer-for-woocommerce' ),
						'number'         => __( 'Number', 'my-account-customizer-for-woocommerce' ),
						'password'       => __( 'Password', 'my-account-customizer-for-woocommerce' ),
						'range'          => __( 'Range', 'my-account-customizer-for-woocommerce' ),
						'tel'            => __( 'Tel', 'my-account-customizer-for-woocommerce' ),
						'text'           => __( 'Text', 'my-account-customizer-for-woocommerce' ),
						'time'           => __( 'Time', 'my-account-customizer-for-woocommerce' ),
						'url'            => __( 'URL', 'my-account-customizer-for-woocommerce' ),
						'week'           => __( 'Week', 'my-account-customizer-for-woocommerce' ),
						'gravatar'       => __( 'Gravatar (Profile Picture)', 'my-account-customizer-for-woocommerce' ),
						'title'          => __( 'Title', 'my-account-customizer-for-woocommerce' ),
					),
				),
				array(
					'type'     => 'sectionend',
					'id'       => "alg_wc_mac_fields[{$i}]",
				),
			) );
		}

		$admin_settings = array(
			array(
				'title'    => __( 'Admin Options', 'my-account-customizer-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_mac_fields_admin_options',
			),
			array(
				'title'    => __( 'Section title', 'my-account-customizer-for-woocommerce' ),
				'desc_tip' => __( 'Fields section title in backend.', 'my-account-customizer-for-woocommerce' ),
				'id'       => 'alg_wc_mac_fields_backend_section_title',
				'default'  => __( 'Extra Profile Fields', 'my-account-customizer-for-woocommerce' ),
				'type'     => 'text',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_mac_fields_admin_options',
			),
		);

		$notes = array(
			array(
				'title'    => __( 'Notes', 'my-account-customizer-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_mac_fields_notes',
				'desc'     => '<p>' . implode( '</p><p>', array(
					$this->get_info_icon() . sprintf(
						/* Translators: %1$s: Type name, %2$s: Option name, %3$s: Description example. */
						__( 'As "%1$s" type is not editable on frontend, we suggest adding something like this to the "%2$s": %3$s.', 'my-account-customizer-for-woocommerce' ),
						__( 'Gravatar', 'my-account-customizer-for-woocommerce' ),
						__( 'Description', 'my-account-customizer-for-woocommerce' ),
						'<code>' .
							esc_html(
								'<a target="_blank" href="https://en.gravatar.com/">' .
									__( 'You can change your profile picture on Gravatar', 'my-account-customizer-for-woocommerce' ) .
								'</a>'
							) .
						'</code>'
					),
				) ) . '</p>',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_mac_fields_notes',
			),
		);

		return array_merge( $fields_settings, $admin_settings, $notes );
	}

}

endif;

return new Alg_WC_MAC_Settings_Fields();
