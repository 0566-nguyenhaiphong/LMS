/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function ( $ ) {

	// Site title.
	wp.customize(
		'blogname',
		function ( value ) {
			value.bind(
				function ( to ) {
					$( '#site-title a' ).text( to );
				}
			);
		}
	);

	// Site description.
	wp.customize(
		'blogdescription',
		function ( value ) {
			value.bind(
				function ( to ) {
					$( '#site-description' ).text( to );
				}
			);
		}
	);

	// Header display type.
	wp.customize(
		'elearning_header_display_type',
		function ( value ) {
			value.bind(
				function ( layout ) {
					var display_type = layout;

					if ( display_type === 'type_two' ) {
						$( 'body' ).removeClass( 'header_display_type_two' ).addClass( 'header_display_type_one' );
					} else if ( display_type === 'type_three' ) {
						$( 'body' ).removeClass( 'header_display_type_one' ).addClass( 'header_display_type_two' );
					} else if ( display_type === 'type_one' ) {
						$( 'body' ).removeClass( 'header_display_type_one header_display_type_two' );
					}
				}
			);
		}
	);

	wp.customize(
		'elearning_page_title_alignment',
		function ( value ) {
			value.bind(
				function ( position ) {
					if ('tg-page-header--left-right' === position) {
						$( '.tg-page-header' ).removeClass( 'tg-page-header--right-left' ).removeClass( 'tg-page-header--both-center' ).removeClass( 'tg-page-header--both-left' ).removeClass( 'tg-page-header--both-right' ).addClass( 'tg-page-header--left-right' );
					} else if ('tg-page-header--right-left' === position) {
						$( '.tg-page-header' ).removeClass( 'tg-page-header--left-right' ).removeClass( 'tg-page-header--both-center' ).removeClass( 'tg-page-header--both-left' ).removeClass( 'tg-page-header--both-right' ).addClass( 'tg-page-header--right-left' );
					} else if ('tg-page-header--both-center' === position) {
						$( '.tg-page-header' ).removeClass( 'tg-page-header--left-right' ).removeClass( 'tg-page-header--right-left' ).removeClass( 'tg-page-header--both-left' ).removeClass( 'tg-page-header--both-right' ).addClass( 'tg-page-header--both-center' );
					} else if ('tg-page-header--both-left' === position) {
						$( '.tg-page-header' ).removeClass( 'tg-page-header--left-right' ).removeClass( 'tg-page-header--right-left' ).removeClass( 'tg-page-header--both-center' ).removeClass( 'tg-page-header--both-right' ).addClass( 'tg-page-header--both-left' );
					} else if ('tg-page-header--both-right' === position) {
						$( '.tg-page-header' ).removeClass( 'tg-page-header--left-right' ).removeClass( 'tg-page-header--right-left' ).removeClass( 'tg-page-header--both-center' ).removeClass( 'tg-page-header--both-left' ).addClass( 'tg-page-header--both-right' );
					}
				}
			);
		}
	);

	// Site Layout Option.
	wp.customize(
		'elearning_site_layout',
		function ( value ) {
			value.bind(
				function ( layout ) {
					var site_layout = layout;

					if ( 'wide_layout' === site_layout ) {
						$( 'body' ).removeClass( 'box-layout' ).addClass( 'wide' );
					} else if ( 'boxed_layout' === site_layout ) {
						$( 'body' ).removeClass( 'wide' ).addClass( 'box-layout' );
					}
				}
			);
		}
	);

	// Footer copyright alignment.
	wp.customize(
		'elearning_footer_copyright_alignment_setting',
		function ( value ) {
			value.bind(
				function ( alignment ) {
					var alignment_type = alignment;

					if ( alignment_type === 'left' ) {
						$( '#colophon' ).removeClass( 'copyright-right copyright-center' );
					} else if ( alignment_type === 'right' ) {
						$( '#colophon' ).removeClass( 'copyright-center' ).addClass( 'copyright-right' );
					} else if ( alignment_type === 'center' ) {
						$( '#colophon' ).removeClass( 'copyright-right' ).addClass( 'copyright-center' );
					}
				}
			);
		}
	);

	// Footer Main Area Display Type.
	wp.customize(
		'elearning_main_footer_layout_display_type',
		function ( value ) {
			value.bind(
				function ( layout ) {
					var display_type = layout;

					if ( display_type === 'type_two' ) {
						$( '#colophon' ).removeClass( 'elearning-footer--classic-bordered' ).addClass( 'elearning-footer--classic' );
					} else if ( display_type === 'type_three' ) {
						$( '#colophon' ).removeClass( 'elearning-footer--classic' ).addClass( 'elearning-footer--classic-bordered' );
					} else if ( display_type === 'type_one' ) {
						$( '#colophon' ).removeClass( 'elearning-footer--classic elearning-footer--classic-bordered' );
					}
				}
			);
		}
	);

} )( jQuery );
