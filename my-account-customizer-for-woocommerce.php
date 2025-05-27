<?php
/*
Plugin Name: My Account Customizer for WooCommerce
Plugin URI: https://wordpress.org/plugins/my-account-customizer-for-woocommerce/
Description: Customize "My account" page. Beautifully.
Version: 2.0.0-dev
Author: Algoritmika Ltd
Author URI: https://profiles.wordpress.org/algoritmika/
Requires at least: 4.4
Text Domain: my-account-customizer-for-woocommerce
Domain Path: /langs
WC tested up to: 9.8
Requires Plugins: woocommerce
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

defined( 'ABSPATH' ) || exit;

if ( 'my-account-customizer-for-woocommerce.php' === basename( __FILE__ ) ) {
	/**
	 * Check if Pro plugin version is activated.
	 *
	 * @version 2.0.0
	 * @since   1.2.0
	 */
	$plugin = 'my-account-customizer-for-woocommerce-pro/my-account-customizer-for-woocommerce-pro.php';
	if (
		in_array( $plugin, (array) get_option( 'active_plugins', array() ), true ) ||
		(
			is_multisite() &&
			array_key_exists( $plugin, (array) get_site_option( 'active_sitewide_plugins', array() ) )
		)
	) {
		defined( 'ALG_WC_MAC_FILE_FREE' ) || define( 'ALG_WC_MAC_FILE_FREE', __FILE__ );
		return;
	}
}

defined( 'ALG_WC_MAC_VERSION' ) || define( 'ALG_WC_MAC_VERSION', '2.0.0-dev-20250527-0943' );

defined( 'ALG_WC_MAC_FILE' ) || define( 'ALG_WC_MAC_FILE', __FILE__ );

require_once plugin_dir_path( __FILE__ ) . 'includes/class-alg-wc-mac.php';

if ( ! function_exists( 'alg_wc_mac' ) ) {
	/**
	 * Returns the main instance of Alg_WC_MAC to prevent the need to use globals.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 */
	function alg_wc_mac() {
		return Alg_WC_MAC::instance();
	}
}

add_action( 'plugins_loaded', 'alg_wc_mac' );
