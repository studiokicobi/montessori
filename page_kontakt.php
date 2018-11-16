<?php
/*
Template Name: Kontakt
*/

// Force full width page content
add_filter('genesis_site_layout', '__genesis_return_full_width_content');

// Remove Genesis content
remove_action('genesis_entry_content', 'genesis_do_post_content');

// Add and start the Advanced Custom Fields loop
add_action('genesis_entry_content', 'acf_loop');

function acf_loop()
{

// ----------------------------------------
    // Add Advanced Custom Fields content below
    // ----------------------------------------

    // Google map
    echo '<div class="map">';

    // Map iframe
    if (get_field('google_maps_embed')):
            the_field('google_maps_embed');
    endif;

    // Close map
    echo '</div>';

    // Map text
    if (get_field('karta_text')):
        the_field('karta_text');
    endif;

    // Contact form wrapper
    echo '<div class="contact-form">';

    // Contact form heading
    if (get_field('form_rubrik')) :
            echo '<h2 class="form-rubrik">';
    the_field('form_rubrik');
    echo '</h2>';
    endif;

    // Contact form intro
    if (get_field('kontaktformular_text')):
            echo '<div class="contact-intro">';
    the_field('kontaktformular_text');
    echo '</div>';
    endif;

    // Contact form
    if (get_field('kontakt_id')) {
        $contact_form_id = get_field('kontakt_id');
        echo do_shortcode('[contact-form-7 id="' . $contact_form_id . '" title="Kontakta oss"]');
    }

    // Close contact form
    echo '</div>';

    // ----------------------------------------
// Close ACF loop
}
// ----------------------------------------

// Run the Genesis loop

genesis();
