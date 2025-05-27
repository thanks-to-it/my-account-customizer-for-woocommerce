<?php
/**
 * My Account Customizer for WooCommerce - Tabs Class
 *
 * @version 2.0.0
 * @since   1.1.0
 *
 * @author  Algoritmika Ltd
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_MAC_Tabs' ) ) :

class Alg_WC_MAC_Tabs {

	/**
	 * custom_tabs.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	public $custom_tabs;

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   1.1.0
	 *
	 * @todo    (dev) `get_option()` only in corresponding hook, i.e. remove `Alg_WC_MAC_Tab` class
	 */
	function __construct() {
		if ( 'yes' === get_option( 'alg_wc_mac_tabs_section_enabled', 'no' ) ) {
			require_once plugin_dir_path( __FILE__ ) . 'classes/class-alg-wc-mac-tab.php';
			foreach ( $this->get_tabs() as $tab ) {
				$this->custom_tabs = new Alg_WC_MAC_Tab( $tab );
			}
		}
		add_action( 'alg_wc_mac_after_save_settings', array( $this, 'flush_rewrite_rules' ) );
	}

	/**
	 * get_tabs.
	 *
	 * @version 1.3.0
	 * @since   1.1.0
	 *
	 * @todo    (dev) cache result in `$this->tabs`?
	 * @todo    (dev) `do_shortcode()`: make sure WPML language constant is defined already, i.e. maybe move all this to the `init` hook?
	 */
	function get_tabs() {
		$tabs       = array();
		$options    = array();
		$options_id = array(
			'enabled',
			'title',
			'id',
			'icon',
			'content',
			'position',
			'visibility_user_roles_action',
			'visibility_user_roles',
			'visibility_users_action',
			'visibility_users',
		);
		foreach ( $options_id as $option_id ) {
			$options[ $option_id ] = get_option( 'alg_wc_mac_tabs_' . $option_id, array() );
		}
		for ( $i = 1; $i <= get_option( 'alg_wc_mac_tabs_total', 1 ); $i++ ) {
			if ( 'yes' === ( isset( $options['enabled'][ $i ] ) ? $options['enabled'][ $i ] : 'yes' ) ) {
				$tab = array();
				foreach ( $options_id as $option_id ) {
					if ( isset( $options[ $option_id ][ $i ] ) ) {
						switch ( $option_id ) {
							case 'title':
							case 'id':
							case 'icon':
							case 'position':
								$value = do_shortcode( $options[ $option_id ][ $i ] );
								break;
							default:
								$value = $options[ $option_id ][ $i ];
						}
					} else { // default value
						switch ( $option_id ) {
							case 'enabled':
								$value = 'yes';
								break;
							case 'title':
								$value = sprintf(
									/* Translators: %s: Tab ID. */
									__( 'Tab %s', 'my-account-customizer-for-woocommerce' ),
									'#' . $i
								);
								break;
							case 'id':
								$value = sprintf( 'tab-%s', $i );
								break;
							case 'visibility_user_roles':
							case 'visibility_users':
								$value = array();
								break;
							default:
								$value = '';
						}
					}
					$tab[ $option_id ] = $value;
				}
				$tabs[ 'alg_wc_mac_' . $i ] = $tab;
			}
		}
		return $tabs;
	}

	/**
	 * flush_rewrite_rules.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 *
	 * @todo    (dev) do we need to check if it's the `tabs` section? i.e. maybe rewrite on any section save?
	 */
	function flush_rewrite_rules() {
		global $current_section;
		if ( $current_section && 'tabs' === $current_section ) {
			flush_rewrite_rules();
		}
	}

}

endif;

return new Alg_WC_MAC_Tabs();
