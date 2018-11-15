<?php
// 404 template. Code via Genesis.

// Remove Skip Links.
remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );
add_action( 'wp_enqueue_scripts', 'genesis_sample_dequeue_skip_links' );
/**
 * Dequeues Skip Links Script.
 *
 * @since 1.0.0
 */
function genesis_sample_dequeue_skip_links() {

	wp_dequeue_script( 'skip-links' );

}

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_after_header', 'add_third_nav' );

// Remove navigation.
remove_theme_support( 'genesis-menus' );

// Remove breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove footer widgets.
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 ); 

// Remove the default loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'genesis_404' );
/**
 * This function outputs a 404 "Not Found" error message.
 *
 * @since 1.6
 */
function genesis_404() {

	genesis_markup( array(
		'open'    => '<article class="entry">',
		'context' => 'entry-404',
	) );

	genesis_markup( array(
		'open'    => '<h1 %s>',
		'close'   => '</h1>',
		'content' => apply_filters( 'genesis_404_entry_title', __( '404', 'genesis' ) ),
		'context' => 'entry-title',
	) );

	echo '<div class="entry-content">';

	if ( genesis_html5() ) :
		/* translators: %s: URL for current website. */
		echo apply_filters( 'genesis_404_entry_content', '<h2>' . 'Sidan kunde inte hittas' . '</h2>' . '<p>' . sprintf( __( 'Vi ber om ursäkt, men på den här adressen finns det inte någon sida. Det kan bero på tillfälliga tekniska problem eller att sidan du försökt nå är borttagen.' . '</p><p>' . '<a href="%s">» Tillbaka till startsidan</a><br>', 'genesis' ), trailingslashit( home_url() ) ) . '</p>' );

	else :
	?>

		<p><?php /* translators: %s: URL for current website. */ printf( __( 'The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it with the information below.', 'genesis' ), esc_url( trailingslashit( home_url() ) ) ); ?></p>

	<?php
	endif;

	echo '</div>';

	genesis_markup( array(
		'close'   => '</article>',
		'context' => 'entry-404',
	) );

}

genesis();
