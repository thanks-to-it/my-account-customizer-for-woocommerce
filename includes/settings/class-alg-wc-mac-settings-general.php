<?php
/**
 * My Account Customizer for WooCommerce - General Section Settings
 *
 * @version 2.0.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_MAC_Settings_General' ) ) :

class Alg_WC_MAC_Settings_General extends Alg_WC_MAC_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function __construct() {
		$this->id   = '';
		$this->desc = __( 'General', 'my-account-customizer-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function get_settings() {

		$sections = array(
			array(
				'title'    => __( 'Sections', 'my-account-customizer-for-woocommerce' ),
				'desc'     => '<table class="widefat striped"><tbody>' .
						'<tr>' .
							'<th>' . __( 'Section', 'my-account-customizer-for-woocommerce' ) . '</th>' .
							'<th>' . __( 'Description', 'my-account-customizer-for-woocommerce' ) . '</th>' .
							'<th></th>' .
						'</tr>' .
						'<tr>' .
							'<td>' . '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=alg_wc_mac&section=fields' ) . '">' . __( 'Fields', 'my-account-customizer-for-woocommerce' ) . '</a>' . '</td>' .
							'<td>' . __( 'Adds custom fields to the "My account > Account details" tab in frontend, and to the user profile page in backend.', 'my-account-customizer-for-woocommerce' ) . '</td>' .
							'<td>' . ( 'yes' === get_option( 'alg_wc_mac_fields_section_enabled', 'no' ) ? '&#9989;' : '' ) . '</td>' .
						'</tr>' .
						'</tr>' .
						'<tr>' .
							'<td>' . '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=alg_wc_mac&section=tabs' ) . '">' . __( 'Tabs', 'my-account-customizer-for-woocommerce' ) . '</a>' . '</td>' .
							'<td>' . __( 'Adds custom tabs to the "My account" page.', 'my-account-customizer-for-woocommerce' ) . '</td>' .
							'<td>' . ( 'yes' === get_option( 'alg_wc_mac_tabs_section_enabled', 'no' ) ? '&#9989;' : '' ) . '</td>' .
						'</tr>' .
					'</tbody></table>',
				'type'     => 'title',
				'id'       => 'alg_wc_mac_sections',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_mac_sections',
			),
		);

		$advanced_settings = array(
			array(
				'title'    => __( 'Advanced Options', 'my-account-customizer-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_mac_advanced_options',
			),
			array(
				'title'    => __( 'Load shortcodes', 'my-account-customizer-for-woocommerce' ),
				'desc'     => __( 'Enable', 'my-account-customizer-for-woocommerce' ),
				'desc_tip' => sprintf(
					/* Translators: %s: Shortcode list. */
					__( 'Will load plugin shortcodes, e.g., %s, etc.', 'my-account-customizer-for-woocommerce' ),
					'<code>' . implode( '</code>, <code>', array(
						'[alg_wc_mac_user_comments]',
						'[alg_wc_mac_translate]',
					) ) . '</code>'
				),
				'id'       => 'alg_wc_mac_load_shortcodes',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Load "Font Awesome"', 'my-account-customizer-for-woocommerce' ),
				'desc'     => __( 'Load', 'my-account-customizer-for-woocommerce' ),
				'desc_tip' => (
					sprintf(
						/* Translators: %s: Site link. */
						__( 'Will load "%s" library on the "My account" page.', 'my-account-customizer-for-woocommerce' ),
						'<a target="_blank" href="https://fontawesome.com/">Font Awesome</a>'
					) . ' ' .
					__( 'Only mark this if you are not loading "Font Awesome" anywhere else. "Font Awesome" is responsible for creating icons.', 'my-account-customizer-for-woocommerce' )
				),
				'id'       => 'alg_wc_mac_load_font_awesome',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'desc_tip' => __( '"Font Awesome" library URL.', 'my-account-customizer-for-woocommerce' ),
				'id'       => 'alg_wc_mac_font_awesome_src',
				'default'  => '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css',
				'type'     => 'text',
				'css'      => 'width:100%;',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_mac_advanced_options',
			),
		);

		return array_merge(
			$sections,
			$advanced_settings
		);
	}

}

endif;

return new Alg_WC_MAC_Settings_General();
