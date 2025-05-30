/**
 * My Account Customizer for WooCommerce - Backend JS
 *
 * @version 2.0.0
 * @since   2.0.0
 *
 * @author  Algoritmika Ltd
 */

jQuery( document ).ready( function () {

	jQuery( '.alg-wc-mac-select-all' ).click( function ( event ) {
		event.preventDefault();
		jQuery( this )
			.closest( 'td' )
			.find( 'select.chosen_select' )
			.select2( 'destroy' )
			.find( 'option' )
			.prop( 'selected', 'selected' )
			.end()
			.select2();
		return false;
	} );

	jQuery( '.alg-wc-mac-deselect-all' ).click( function ( event ) {
		event.preventDefault();
		jQuery( this )
			.closest( 'td' )
			.find( 'select.chosen_select' )
			.val( '' )
			.change();
		return false;
	} );

} );
