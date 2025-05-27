<?php
/**
 * My Account Customizer for WooCommerce - Section Settings
 *
 * @version 2.0.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_MAC_Settings_Section' ) ) :

class Alg_WC_MAC_Settings_Section {

	/**
	 * id.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	public $id;

	/**
	 * desc.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	public $desc;

	/**
	 * Constructor.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 */
	function __construct() {
		add_filter(
			'woocommerce_get_sections_alg_wc_mac',
			array( $this, 'settings_section' )
		);
		add_filter(
			'woocommerce_get_settings_alg_wc_mac_' . $this->id,
			array( $this, 'get_settings' ),
			PHP_INT_MAX
		);
	}

	/**
	 * settings_section.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function settings_section( $sections ) {
		$sections[ $this->id ] = $this->desc;
		return $sections;
	}

	/**
	 * get_save_changes_desc.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	function get_save_changes_desc() {
		return __( 'New settings fields will be displayed if you change this option and "Save changes".', 'my-account-customizer-for-woocommerce' );
	}

	/**
	 * get_info_icon.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 *
	 * @see     https://developer.wordpress.org/resource/dashicons/
	 */
	function get_info_icon() {
		return '<span class="dashicons dashicons-info"></span> ';
	}

}

endif;
