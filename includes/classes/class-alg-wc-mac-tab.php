<?php
/**
 * My Account Customizer for WooCommerce - Tab Class
 *
 * @version 2.0.0
 * @since   1.1.0
 *
 * @author  Algoritmika Ltd
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_MAC_Tab' ) ) :

class Alg_WC_MAC_Tab {

	/**
	 * data.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	public $data;

	/**
	 * Constructor.
	 *
	 * @version 1.3.0
	 * @since   1.1.0
	 */
	function __construct( $data ) {

		// Properties
		$this->data = $data;
		if ( '' === $this->data['title'] ) {
			return false;
		}
		if ( '' === $this->data['id'] ) {
			$this->data['id'] = sanitize_title( $this->data['title'] );
		}

		// Hooks
		add_filter( 'the_title',                                              array( $this, 'endpoint_title' ) );
		add_action( 'init',                                                   array( $this, 'add_endpoint' ) );
		add_filter( 'query_vars',                                             array( $this, 'query_vars' ), 0 );
		add_filter( 'woocommerce_account_menu_items',                         array( $this, 'add_link' ) );
		add_action( 'woocommerce_account_' . $this->data['id'] . '_endpoint', array( $this, 'get_content' ) );
		add_action( 'wp_head',                                                array( $this, 'set_icon' ) );

	}

	/**
	 * is_visible.
	 *
	 * @version 1.3.0
	 * @since   1.3.0
	 */
	function is_visible() {
		if (
			! empty( $this->data['visibility_user_roles_action'] ) &&
			! empty( $this->data['visibility_user_roles'] )
		) {
			$is_user_role = ! empty(
				array_intersect(
					( array ) wp_get_current_user()->roles,
					$this->data['visibility_user_roles']
				)
			);
			if (
				(
					'exclude' === $this->data['visibility_user_roles_action'] &&
					$is_user_role
				) ||
				(
					'include' === $this->data['visibility_user_roles_action'] &&
					! $is_user_role
				)
			) {
				return false;
			}
		}
		if (
			! empty( $this->data['visibility_users_action'] ) &&
			! empty( $this->data['visibility_users'] )
		) {
			$is_user = in_array( get_current_user_id(), $this->data['visibility_users'] );
			if (
				(
					'exclude' === $this->data['visibility_users_action'] &&
					$is_user
				) ||
				(
					'include' === $this->data['visibility_users_action'] &&
					! $is_user
				)
			) {
				return false;
			}
		}
		return true;
	}

	/**
	 * set_icon.
	 *
	 * @version 2.0.0
	 * @since   1.1.0
	 */
	function set_icon() {
		if ( $this->data['icon'] ) {
			echo '<style>' .
				'.woocommerce-MyAccount-navigation ul li.woocommerce-MyAccount-navigation-link--' . esc_attr( $this->data['id'] ) . ' a::before { ' . 'content: "\\' . esc_attr( $this->data['icon'] ) . '";' . ' }' .
			'</style>';
		}
	}

	/**
	 * get_content.
	 *
	 * @version 1.3.0
	 * @since   1.1.0
	 */
	function get_content() {
		echo ( $this->is_visible() ? do_shortcode( $this->data['content'] ) : '' );
	}

	/**
	 * add_link.
	 *
	 * @version 1.3.0
	 * @since   1.1.0
	 *
	 * @todo    (feature) customizable position: before/after (now always after)
	 */
	function add_link( $items ) {
		if ( ! $this->is_visible() ) {
			return $items;
		}
		$_items   = array();
		$is_added = false;
		foreach ( $items as $id => $item ) {
			$_items[ $id ] = $item;
			if ( $this->data['position'] == $id ) {
				$_items[ $this->data['id'] ] = $this->data['title'];
				$is_added = true;
			}
		}
		if ( ! $is_added ) {
			$_items[ $this->data['id'] ] = $this->data['title'];
		}
		return $_items;
	}

	/**
	 * query_vars.
	 *
	 * @version 1.3.0
	 * @since   1.1.0
	 */
	function query_vars( $vars ) {
		$vars[] = $this->data['id'];
		return $vars;
	}

	/**
	 * add_endpoint.
	 *
	 * @version 1.3.0
	 * @since   1.1.0
	 */
	function add_endpoint() {
		add_rewrite_endpoint( $this->data['id'], EP_ROOT | EP_PAGES );
	}

	/**
	 * endpoint_title.
	 *
	 * @version 1.3.0
	 * @since   1.1.0
	 */
	function endpoint_title( $title ) {
		global $wp_query;
		$is_endpoint = isset( $wp_query->query_vars[ $this->data['id'] ] );
		if (
			$is_endpoint &&
			! is_admin() &&
			is_main_query() &&
			in_the_loop() &&
			is_account_page() &&
			$this->is_visible()
		) {
			$title = $this->data['title'];
			remove_filter( 'the_title', array( $this, 'endpoint_title' ) );
		}
		return $title;
	}

}

endif;
