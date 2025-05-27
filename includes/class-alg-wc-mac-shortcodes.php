<?php
/**
 * My Account Customizer for WooCommerce - Shortcodes Class
 *
 * @version 1.2.0
 * @since   1.1.0
 *
 * @author  Algoritmika Ltd
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_MAC_Shortcodes' ) ) :

class Alg_WC_MAC_Shortcodes {

	/**
	 * Constructor.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 *
	 * @todo    (feature) add more shortcodes for custom tabs
	 */
	function __construct() {
		add_shortcode( 'alg_wc_mac_user_comments', array( $this, 'user_comments' ) );
		add_shortcode( 'alg_wc_mac_translate',     array( $this, 'translate' ) );
	}

	/**
	 * user_comments.
	 *
	 * @version 1.2.0
	 * @since   1.1.0
	 *
	 * @see     https://developer.wordpress.org/reference/functions/get_comments/
	 * @see     https://developer.wordpress.org/reference/classes/wp_comment_query/__construct/
	 * @see     https://developer.wordpress.org/reference/classes/wp_comment/
	 *
	 * @todo    (dev) `$args`: add more?
	 * @todo    (dev) placeholders: add more, e.g. `review_rating`, `comment_author_IP`?
	 * @todo    (dev) placeholders: format, e.g. `comment_type`?
	 */
	function user_comments( $atts, $content = '' ) {
		$default_atts = array(
			// Query
			'type'            => '',
			'orderby'         => '',
			'order'           => 'DESC',
			'number'          => '',
			'status'          => 'all',
			// Output
			'before'          => '<table><tbody>' .
				sprintf( '<tr><th>%s</th><th>%s</th></tr>', __( 'Date', 'my-account-customizer-for-woocommerce' ), __( 'Content', 'my-account-customizer-for-woocommerce' ) ),
			'after'           => '</tbody></table>',
			'row'             => '<tr><td>%comment_date%</td><td>%comment_content%</td></tr>',
			'glue'            => '',
			'on_empty'        => __( 'No comments found.', 'my-account-customizer-for-woocommerce' ),
			// Formating
			'on_approved'     => __( 'Approved', 'my-account-customizer-for-woocommerce' ),
			'on_unapproved'   => __( 'Unapproved', 'my-account-customizer-for-woocommerce' ),
			'datetime_format' => get_option( 'date_format' ) . ' ' . get_option( 'time_format' ),
		);
		$atts         = shortcode_atts( $default_atts, $atts, 'alg_wc_mac_user_comments' );
		$rows         = array();
		$args         = array(
			'user_id' => get_current_user_id(),
			'type'    => array_map( 'trim', explode( ',', $atts['type'] ) ),
			'orderby' => $atts['orderby'],
			'order'   => $atts['order'],
			'number'  => $atts['number'],
			'status'  => $atts['status'],
		);
		$comments     = get_comments( $args );
		foreach ( $comments as $i => $comment ) {
			$placeholders = array(
				'%comment_nr%'          => ( $i + 1 ),
				'%comment_ID%'          => $comment->comment_ID,
				'%comment_post_ID%'     => $comment->comment_post_ID,
				'%comment_date%'        => date_i18n( $atts['datetime_format'], strtotime( $comment->comment_date ) ),
				'%comment_content%'     => $comment->comment_content,
				'%comment_karma%'       => $comment->comment_karma,
				'%comment_approved%'    => ( 1 == $comment->comment_approved ? $atts['on_approved'] : $atts['on_unapproved'] ),
				'%comment_type%'        => $comment->comment_type,
				'%comment_parent%'      => $comment->comment_parent,
				'%comment_status%'      => $comment->comment_status,
				'%comment_link%'        => get_comment_link( $comment->comment_ID ),
				'%comment_parent_link%' => ( $comment->comment_parent  ? get_comment_link(  $comment->comment_parent )  : '' ),
				'%comment_post_link%'   => ( $comment->comment_post_ID ? get_the_permalink( $comment->comment_post_ID ) : '' ),
				'%comment_post_title%'  => ( $comment->comment_post_ID ? get_the_title(     $comment->comment_post_ID ) : '' ),
			);
			$rows[] = str_replace( array_keys( $placeholders ), $placeholders, $atts['row'] );
		}
		return ( ! empty( $rows ) ? ( $atts['before'] . implode( $atts['glue'], $rows ) . $atts['after'] ) : $atts['on_empty'] );
	}

	/**
	 * translate.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 *
	 * @todo    (dev) return `do_shortcode( $content )`?
	 */
	function translate( $atts, $content = '' ) {
		// E.g.: `[alg_wc_mac_translate lang="EN,DE" lang_text="Text for EN & DE" not_lang_text="Text for other languages"]`
		if ( isset( $atts['lang_text'] ) && isset( $atts['not_lang_text'] ) && ! empty( $atts['lang'] ) ) {
			return ( ! defined( 'ICL_LANGUAGE_CODE' ) || ! in_array( strtolower( ICL_LANGUAGE_CODE ), array_map( 'trim', explode( ',', strtolower( $atts['lang'] ) ) ) ) ) ?
				$atts['not_lang_text'] : $atts['lang_text'];
		}
		// E.g.: `[alg_wc_mac_translate lang="EN,DE"]Text for EN & DE[/alg_wc_mac_translate][alg_wc_mac_translate not_lang="EN,DE"]Text for other languages[/alg_wc_mac_translate]`
		return (
			( ! empty( $atts['lang'] )     && ( ! defined( 'ICL_LANGUAGE_CODE' ) || ! in_array( strtolower( ICL_LANGUAGE_CODE ), array_map( 'trim', explode( ',', strtolower( $atts['lang'] ) ) ) ) ) ) ||
			( ! empty( $atts['not_lang'] ) &&     defined( 'ICL_LANGUAGE_CODE' ) &&   in_array( strtolower( ICL_LANGUAGE_CODE ), array_map( 'trim', explode( ',', strtolower( $atts['not_lang'] ) ) ) ) )
		) ? '' : $content;
	}

}

endif;

return new Alg_WC_MAC_Shortcodes();
