<?php
/**
 * My Account Customizer for WooCommerce - Core Class
 *
 * @version 2.0.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_MAC_Core' ) ) :

class Alg_WC_MAC_Core {

	/**
	 * fields.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	public $fields;

	/**
	 * tabs.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	public $tabs;

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 *
	 * @todo    (dev) move this to `class-alg-wc-mac.php`?
	 * @todo    (feature) option to change icons for the existing/default "My account" sections
	 * @todo    (feature) "Privacy section" (i.e., emails they want to receive, etc.)
	 * @todo    (dev) only load/run anything if it's `is_account_page()`?
	 */
	function __construct() {

		// Shortcodes
		if ( 'yes' === get_option( 'alg_wc_mac_load_shortcodes', 'yes' ) ) {
			require_once plugin_dir_path( __FILE__ ) . 'class-alg-wc-mac-shortcodes.php';
		}

		// Font Awesome
		if ( 'yes' === get_option( 'alg_wc_mac_load_font_awesome', 'no' ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'load_font_awesome' ) );
		}

		// "Account details" fields
		$this->fields = require_once plugin_dir_path( __FILE__ ) . 'class-alg-wc-mac-fields.php';

		// Custom tabs
		$this->tabs = require_once plugin_dir_path( __FILE__ ) . 'class-alg-wc-mac-tabs.php';

		// Core loaded
		do_action( 'alg_wc_mac_core_loaded' );

	}

	/**
	 * load_font_awesome.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 *
	 * @todo    (dev) retest this
	 */
	function load_font_awesome() {
		if ( is_account_page() ) {
			$src = get_option(
				'alg_wc_mac_font_awesome_src',
				'//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'
			);
			wp_enqueue_style(
				'alg-wc-mac-font-awesome',
				$src,
				array(),
				alg_wc_mac()->version
			);
		}
	}

}

endif;

return new Alg_WC_MAC_Core();
