<?php
/**
 * My Account Customizer for WooCommerce - Settings
 *
 * @version 2.0.0
 * @since   1.0.0
 *
 * @author  Algoritmika Ltd
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_MAC_Settings' ) ) :

class Alg_WC_MAC_Settings extends WC_Settings_Page {

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function __construct() {

		$this->id    = 'alg_wc_mac';
		$this->label = __( 'My Account Customizer', 'my-account-customizer-for-woocommerce' );
		parent::__construct();

		// Sections
		require_once plugin_dir_path( __FILE__ ) . 'class-alg-wc-mac-settings-section.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-alg-wc-mac-settings-general.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-alg-wc-mac-settings-fields.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-alg-wc-mac-settings-tabs.php';

	}

	/**
	 * get_settings.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function get_settings() {
		global $current_section;
		return array_merge(
			apply_filters( 'woocommerce_get_settings_' . $this->id . '_' . $current_section, array() ),
			array(
				array(
					'title'     => __( 'Reset Settings', 'my-account-customizer-for-woocommerce' ),
					'type'      => 'title',
					'id'        => $this->id . '_' . $current_section . '_reset_options',
				),
				array(
					'title'     => __( 'Reset section settings', 'my-account-customizer-for-woocommerce' ),
					'desc'      => '<strong>' . __( 'Reset', 'my-account-customizer-for-woocommerce' ) . '</strong>',
					'desc_tip'  => __( 'Check the box and save changes to reset.', 'my-account-customizer-for-woocommerce' ),
					'id'        => $this->id . '_' . $current_section . '_reset',
					'default'   => 'no',
					'type'      => 'checkbox',
				),
				array(
					'type'      => 'sectionend',
					'id'        => $this->id . '_' . $current_section . '_reset_options',
				),
			)
		);
	}

	/**
	 * maybe_reset_settings.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function maybe_reset_settings() {
		global $current_section;
		if ( 'yes' === get_option( $this->id . '_' . $current_section . '_reset', 'no' ) ) {
			foreach ( $this->get_settings() as $value ) {
				if ( isset( $value['id'] ) ) {
					$id = explode( '[', $value['id'] );
					delete_option( $id[0] );
				}
			}
			add_action(
				'admin_notices',
				array( $this, 'admin_notices_settings_reset_success' ),
				PHP_INT_MAX
			);
		}
	}

	/**
	 * admin_notices_settings_reset_success.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function admin_notices_settings_reset_success() {
		echo '<div class="notice notice-success is-dismissible"><p><strong>' .
			esc_html__( 'Your settings have been reset.', 'my-account-customizer-for-woocommerce' ) .
		'</strong></p></div>';
	}

	/**
	 * save.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 */
	function save() {
		parent::save();
		$this->maybe_reset_settings();
		do_action( 'alg_wc_mac_after_save_settings' );
	}

	/**
	 * Output sections.
	 *
	 * @version 2.0.0
	 * @since   1.1.0
	 *
	 * @see     https://github.com/woocommerce/woocommerce/blob/4.9.2/includes/admin/settings/class-wc-settings-page.php#L100
	 */
	function output_sections() {
		global $current_section;

		$sections = $this->get_sections();

		if ( empty( $sections ) || 1 === sizeof( $sections ) ) {
			return;
		}

		echo '<ul class="subsubsub">';

		$array_keys = array_keys( $sections );

		foreach ( $sections as $id => $label ) {
			$url = admin_url(
				'admin.php' .
				'?page=wc-settings' .
				'&tab=' . $this->id .
				'&section=' . sanitize_title( $id )
			);
			echo '<li>' .
				'<a' .
					' href="' . esc_url( $url ) . '"' .
					' class="' . ( $current_section == $id ? 'current' : '' ) . '"' .
				'>' .
					wp_kses_post( $this->style_section_label( $label, $id ) ) .
				'</a> ' .
				( end( $array_keys ) == $id ? '' : '|' ) . ' ' .
			'</li>';
		}

		echo '</ul><br class="clear" />';
	}

	/**
	 * style_section_label.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	function style_section_label( $label, $id ) {
		return (
			'yes' === get_option( "alg_wc_mac_{$id}_section_enabled", 'no' ) ?
			'<span style="color:green;">' . $label . '</span>' :
			$label
		);
	}

}

endif;

return new Alg_WC_MAC_Settings();
