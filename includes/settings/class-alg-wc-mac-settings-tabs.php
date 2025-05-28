<?php
/**
 * My Account Customizer for WooCommerce - Tabs Section Settings
 *
 * @version 2.0.0
 * @since   1.1.0
 *
 * @author  Algoritmika Ltd
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_MAC_Settings_Tabs' ) ) :

class Alg_WC_MAC_Settings_Tabs extends Alg_WC_MAC_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   1.1.0
	 */
	function __construct() {

		$this->id   = 'tabs';
		$this->desc = __( 'Tabs', 'my-account-customizer-for-woocommerce' );
		parent::__construct();

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}

	/**
	 * enqueue_scripts.
	 *
	 * @version 2.0.0
	 * @since   1.3.0
	 */
	function enqueue_scripts( $hook_suffix ) {

		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		if (
			! isset( $_GET['page'], $_GET['tab'], $_GET['section'] ) ||
			'wc-settings' !== $_GET['page'] ||
			'alg_wc_mac'  !== $_GET['tab'] ||
			'tabs'        !== $_GET['section']
		) {
			return;
		}
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		$min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.min' : '' );
		$url = '/includes/js/class-alg-wc-mac-backend' . $min . '.js';

		wp_enqueue_script(
			'class-alg-wc-mac-backend',
			alg_wc_mac()->plugin_url() . $url,
			array(),
			alg_wc_mac()->version,
			true
		);

	}

	/**
	 * get_select_all_buttons.
	 *
	 * @version 1.3.0
	 * @since   1.3.0
	 */
	function get_select_all_buttons() {
		return
			'<a href="#" class="button alg-wc-mac-select-all">' .
				__( 'Select all', 'my-account-customizer-for-woocommerce' ) .
			'</a>' . ' ' .
			'<a href="#" class="button alg-wc-mac-deselect-all">' .
				__( 'Deselect all', 'my-account-customizer-for-woocommerce' ) .
			'</a>';
	}

	/**
	 * get_settings.
	 *
	 * @version 2.0.0
	 * @since   1.1.0
	 *
	 * @todo    (dev) "User roles" and "Users": ajax
	 * @todo    (desc) better desc, e.g., for the "Content" option?
	 * @todo    (dev) content: raw?
	 * @todo    (dev) better default values?
	 */
	function get_settings() {

		$settings = array(
			array(
				'title'             => __( 'Custom Tabs Options', 'my-account-customizer-for-woocommerce' ),
				'desc'              => __( 'Adds custom tabs to the "My account" page.', 'my-account-customizer-for-woocommerce' ),
				'type'              => 'title',
				'id'                => 'alg_wc_mac_tabs_options',
			),
			array(
				'title'             => __( 'Tabs', 'my-account-customizer-for-woocommerce' ),
				'desc'              => '<strong>' . __( 'Enable section', 'my-account-customizer-for-woocommerce' ) . '</strong>',
				'type'              => 'checkbox',
				'id'                => 'alg_wc_mac_tabs_section_enabled',
				'default'           => 'no',
			),
			array(
				'title'             => __( 'Total tabs', 'my-account-customizer-for-woocommerce' ),
				'desc_tip'          => $this->get_save_changes_desc(),
				'type'              => 'number',
				'id'                => 'alg_wc_mac_tabs_total',
				'default'           => 1,
				'custom_attributes' => array( 'min' => 0 ),
			),
			array(
				'type'              => 'sectionend',
				'id'                => 'alg_wc_mac_tabs_options',
			),
		);
		for ( $i = 1; $i <= get_option( 'alg_wc_mac_tabs_total', 1 ); $i++ ) {
			$settings = array_merge( $settings, array(
				array(
					'title'    => sprintf(
						/* Translators: %s: Tab ID. */
						__( 'Tab %s', 'my-account-customizer-for-woocommerce' ),
						'#' . $i
					),
					'type'     => 'title',
					'id'       => "alg_wc_mac_tabs[{$i}]",
				),
				array(
					'title'    => __( 'Enable/Disable', 'my-account-customizer-for-woocommerce' ),
					'desc'     => '<strong>' . sprintf(
						/* Translators: %s: Tab ID. */
						__( 'Enable tab %s', 'my-account-customizer-for-woocommerce' ),
						'#' . $i
					) . '</strong>',
					'id'       => "alg_wc_mac_tabs_enabled[{$i}]",
					'default'  => 'yes',
					'type'     => 'checkbox',
				),
				array(
					'title'    => __( 'Title', 'my-account-customizer-for-woocommerce' ),
					'desc_tip' => (
						__( 'Can not be empty.', 'my-account-customizer-for-woocommerce' ) . '<br>' .
						sprintf(
							/* Translators: %s: Shortcode example. */
							__( 'You can use shortcodes here, e.g.: %s.', 'my-account-customizer-for-woocommerce' ),
							'<em>[alg_wc_mac_translate]</em>'
						)
					),
					'id'       => "alg_wc_mac_tabs_title[{$i}]",
					'default'  => sprintf(
						/* Translators: %s: Tab ID. */
						__( 'Tab %s', 'my-account-customizer-for-woocommerce' ),
						'#' . $i
					),
					'type'     => 'text',
				),
				array(
					'title'    => __( 'ID', 'my-account-customizer-for-woocommerce' ),
					'desc_tip' => (
						__( 'If empty, then it will automatically generated from the title.', 'my-account-customizer-for-woocommerce' ) . '<br>' .
						sprintf(
							/* Translators: %s: Shortcode example. */
							__( 'You can use shortcodes here, e.g.: %s.', 'my-account-customizer-for-woocommerce' ),
							'<em>[alg_wc_mac_translate]</em>'
						)
					),
					'id'       => "alg_wc_mac_tabs_id[{$i}]",
					'default'  => sprintf( 'tab-%s', $i ),
					'type'     => 'text',
				),
				array(
					'title'    => __( 'Icon', 'my-account-customizer-for-woocommerce' ),
					'desc'     => sprintf(
						/* Translators: %1$s: Icon code example, %2$s: Site link. */
						__( 'You need to enter icon code here, e.g., %1$s. Icon codes are available on %2$s site.', 'my-account-customizer-for-woocommerce' ),
						'<code>f2b9</code>',
						'<a href="https://fontawesome.com/icons?d=gallery&s=regular&m=free" target="_blank">Font Awesome</a>'
					),
					'desc_tip' => (
						__( 'Will use the default icon if empty.', 'my-account-customizer-for-woocommerce' ) . '<br>' .
						sprintf(
							/* Translators: %s: Shortcode example. */
							__( 'You can use shortcodes here, e.g.: %s.', 'my-account-customizer-for-woocommerce' ),
							'<em>[alg_wc_mac_translate]</em>'
						)
					),
					'id'       => "alg_wc_mac_tabs_icon[{$i}]",
					'default'  => '',
					'type'     => 'text',
				),
				array(
					'title'    => __( 'Content', 'my-account-customizer-for-woocommerce' ),
					'desc_tip' => sprintf(
						/* Translators: %s: Shortcode example. */
						__( 'You can use shortcodes here, e.g.: %s.', 'my-account-customizer-for-woocommerce' ),
						'<em>[alg_wc_mac_translate]</em>'
					),
					'id'       => "alg_wc_mac_tabs_content[{$i}]",
					'default'  => '',
					'type'     => 'textarea',
					'css'      => 'width:100%;height:100px;',
				),
				array(
					'title'    => __( 'Position', 'my-account-customizer-for-woocommerce' ),
					'desc'     => (
						sprintf(
							/* Translators: %1$s: Tab ID example, %2$s: Tab ID example. */
							__( 'Enter tab ID here. E.g.: %1$s or %2$s. Custom tab will be added right after it.', 'my-account-customizer-for-woocommerce' ),
							'<code>orders</code>',
							'<code>dashboard</code>'
						) . ' ' .
						__( 'Leave empty to add to the last position.', 'my-account-customizer-for-woocommerce' )
					),
					'desc_tip' => sprintf(
						/* Translators: %s: Shortcode example. */
						__( 'You can use shortcodes here, e.g.: %s.', 'my-account-customizer-for-woocommerce' ),
						'<em>[alg_wc_mac_translate]</em>'
					),
					'id'       => "alg_wc_mac_tabs_position[{$i}]",
					'default'  => '',
					'type'     => 'text',
				),
				array(
					'title'    => __( 'Visibility', 'my-account-customizer-for-woocommerce' ),
					'id'       => "alg_wc_mac_tabs_visibility_user_roles_action[{$i}]",
					'default'  => 'exclude',
					'type'     => 'select',
					'class'    => 'chosen_select',
					'options'  => array(
						''        => __( 'All user roles', 'my-account-customizer-for-woocommerce' ),
						'exclude' => __( 'Exclude selected user roles', 'my-account-customizer-for-woocommerce' ), // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude
						'include' => __( 'Require selected user roles', 'my-account-customizer-for-woocommerce' ),
					),
				),
				array(
					'desc_tip' => __( 'User roles.', 'my-account-customizer-for-woocommerce' ) . ' ' . __( 'Ignored if empty.', 'my-account-customizer-for-woocommerce' ),
					'desc'     => $this->get_select_all_buttons(),
					'id'       => "alg_wc_mac_tabs_visibility_user_roles[{$i}]",
					'default'  => array(),
					'type'     => 'multiselect',
					'class'    => 'chosen_select',
					'options'  => wp_list_pluck( wp_roles()->roles, 'name' ),
				),
				array(
					'id'       => "alg_wc_mac_tabs_visibility_users_action[{$i}]",
					'default'  => 'exclude',
					'type'     => 'select',
					'class'    => 'chosen_select',
					'options'  => array(
						''        => __( 'All users', 'my-account-customizer-for-woocommerce' ),
						'exclude' => __( 'Exclude selected users', 'my-account-customizer-for-woocommerce' ), // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude
						'include' => __( 'Require selected users', 'my-account-customizer-for-woocommerce' ),
					),
				),
				array(
					'desc_tip' => __( 'Users.', 'my-account-customizer-for-woocommerce' ) . ' ' . __( 'Ignored if empty.', 'my-account-customizer-for-woocommerce' ),
					'desc'     => $this->get_select_all_buttons(),
					'id'       => "alg_wc_mac_tabs_visibility_users[{$i}]",
					'default'  => array(),
					'type'     => 'multiselect',
					'class'    => 'chosen_select',
					'options'  => ( ( $users = get_users() ) ? array_combine( wp_list_pluck( $users, 'ID' ), wp_list_pluck( $users, 'nickname' ) ) : array() ),
				),
				array(
					'type'     => 'sectionend',
					'id'       => "alg_wc_mac_tabs[{$i}]",
				),
			) );
		}

		return $settings;
	}

}

endif;

return new Alg_WC_MAC_Settings_Tabs();
