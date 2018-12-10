<?php
/*
Template Name: Intranät
*/

// This template serves all the intranet pages

// Check if user is logged in
if (!is_user_logged_in()) {

// User is not logged in. Redirect browser to #login modal form.
    $url = home_url('/#login');
    header("Location: $url");
    exit();
} else {
    // User is logged in.

    // Add and start the Advanced Custom Fields loop
    add_action('genesis_entry_content', 'acf_loop');

    function acf_loop()
    {

// ----------------------------------------
// Add Advanced Custom Fields content below
// ---------------------------------------- ?>

<?php // Intranät start page
if (is_page(856)) {
  // Get current user email
  $current_user = wp_get_current_user();
  echo '<p>Din e-postadress är <strong>' . $current_user->user_email . '</strong>.<br /><a href="mailto:webmaster@skargardensmontessori.se">Kontakta webbgruppen</a> om du behöver ändra adressen.</p>' ;

  // Show member profile form
echo do_shortcode( ' [frontend_member_form field_group="2558"] ' );

  // Close Intranät start page page
} ?>


<?php
// Page = Medlemslista

// <table>
//   <tr>
//     <th>Firstname</th>
//     <th>Lastname</th>
//     <th>Age</th>
//   </tr>
//   <tr>
//     <td>Eve</td>
//     <td>Jackson</td>
//     <td>94</td>
//   </tr>
// </table>


if (is_page(867)) {
    if (have_rows('medlemslista')) :
?>
		<table class="medlemslista">
      <tr class="list-heading">
        <th class="barn barn-heading">Barn</th>
        <th class="parents parent-heading">Föräldrar</th>
        <th class="links links-heading">Tel. & E-post</th>
      </tr>

    <?php while (have_rows('medlemslista')) : the_row();

    echo '<tr class="member-data-row">';
    // Parent 1
    // Retrieve array for parent 1 and store the keys
    // var_dump( $foralder_1_array );
    $foralder_1_array = get_sub_field('foralder_1');
    $arrayKeys = array_keys($foralder_1_array);
    // Return the user ID, name and email from the array
    $id_1 = $foralder_1_array[$arrayKeys[0]];
    $first_name_1 = $foralder_1_array[$arrayKeys[1]];
    $last_name_1 = $foralder_1_array[$arrayKeys[2]];
    $email_1 = $foralder_1_array[$arrayKeys[6]];
    // Get the tel. from the custom user profilefield
    $tel_1 = get_field('telnr', 'user_'. $id_1);

    // Parent 2
    // Retrieve array for parent 2 and store the keys
    // var_dump( $foralder_2_array );
    $foralder_2_array = get_sub_field('foralder_2');
    $arrayKeys = array_keys($foralder_2_array);
    // Return the user ID, name and email from the array
    $id_2 = $foralder_2_array[$arrayKeys[0]];
    $first_name_2 = $foralder_2_array[$arrayKeys[1]];
    $last_name_2 = $foralder_2_array[$arrayKeys[2]];
    $email_2 = $foralder_2_array[$arrayKeys[6]];
    // Get the tel. from the custom user profilefield
    $tel_2 = get_field('telnr', 'user_'. $id_2);

    // Child names
    $child_1 = get_sub_field('barn_1');
    $child_2 = get_sub_field('barn_2');
    $child_3 = get_sub_field('barn_3');

    // Print Child's name
    echo '<td class="barn">';
      if ($child_1) : echo $child_1;
        endif;
      if ($child_2) : echo '<br />' . '<span class="child-plus">' . $child_2 . '</span>';
        endif;
      if ($child_3) : echo '<br />' . '<span class="child-plus-plus">' . $child_3 . '</span>';
        endif;
    echo '</td>';

    echo '<td class="parents">';
      // Parent 1 name
      if ($first_name_1) : echo '<span class="parent">' . $first_name_1 . ' ' . $last_name_1 . '</span>';
        endif;
      // If parent 2 exists, add line break
      if ($first_name_2) : echo '<br />';
        endif;
      // If parent 2 exists, print parent 2 name
      if ($first_name_2) : echo '<span class="parent">' . $first_name_2 . ' ' . $last_name_2 . '</span>';
        endif;
    echo '</td>';

    echo '<td class="links">';
      // If parent 2 name exists, print tel + email links
      if ($first_name_1 && $tel_1) : echo '<a href="tel:' . $tel_1 . '"' . 'data-tooltip="' . $tel_1 . '"' . '>' . '<span class="tel-link dashicons-before dashicons-phone">' . $tel_1 . '</span>' . '</a>';
        endif;
      if ($first_name_1 && $email_1) : echo '<a href="mailto:' . $email_1 . '"' . 'data-tooltip="' . $email_1 . '"' . '>' . '<span class="email-link dashicons-before dashicons-email-alt">' . $email_1 . '</span>' . '</a>';
        endif;
      // If parent 2 exists, add line break
      if ($first_name_2) : echo '<br />';
        endif;
      // If parent 2 name exists, print tel + email links
      if ($first_name_2 && $tel_2) : echo '<a href="tel:' . $tel_2 . '"' . 'data-tooltip="' . $tel_2 . '"' . '>' . '<span class="tel-link dashicons-before dashicons-phone">' . $tel_2 . '</span>' . '</a>';
        endif;
      if ($first_name_2 && $email_2) : echo '<a href="mailto:' . $email_2 . '"' . 'data-tooltip="' . $email_2 . '"' . '>' . '<span class="email-link dashicons-before dashicons-email-alt">' . $email_2 . '</span>' . '</a>';
        endif;
    echo '</td>';
    echo '</tr>';

    endwhile;

    echo '</table>';

    else :
        // no rows found
    endif;

    // Close Medlemslista page
} ?>

<?php
// Page = Uppdrag

if (is_page(890)) {
    echo '<h2>Aktivitetsgruppen</h2>';
    // Get ACF meta value for activity group and echo user in the group
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Aktivitetsgruppen'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->email) . '">' . esc_html($user->email) . '</a>' . '</p>';
    }


    echo '<h2>Fadderfamiljen</h2>';
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Fadderfamiljen'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->email) . '">' . esc_html($user->email) . '</a>' . '</p>';
    }

    echo '<h2>Hantverksgruppen</h2>';
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Hantverksgruppen'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->email) . '">' . esc_html($user->email) . '</a>' . '</p>';
    }

    echo '<h2>Städmaterialansvarig</h2>';
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Städmaterialansvarig'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->email) . '">' . esc_html($user->email) . '</a>' . '</p>';
    }

    echo '<h2>Städplaneringsansvarig</h2>';
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Städplaneringsansvarig'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->email) . '">' . esc_html($user->email) . '</a>' . '</p>';
    }

    echo '<h2>Webbgruppen</h2>';
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Webbgruppen'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->email) . '">' . esc_html($user->email) . '</a>' . '</p>';
    }
    // Close Aktivitetsgruppen page
} ?>


<?php wp_reset_query(); ?>

<?php
// Page = Styrelsen

if (is_page(859)) {
    if (get_field('inledningstext')):
        the_field('inledningstext');
    endif;

    echo '<h2>Styrelse Ordförande</h2>';
    // Get ACF meta value for activity group and echo user in the group
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Styrelse Ordförande'));
    foreach ($mont_users as $user) {
        echo '<p class="position">' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->user_email) . '">' . esc_html($user->user_email) . '</a>' . '</p>';
    }

    if (get_field('ordforande_beskrivning')):
        the_field('ordforande_beskrivning');
    endif;

    echo '<h2>Styrelse Vice ordförande</h2>';
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Styrelse Vice ordförande'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->user_email) . '">' . esc_html($user->user_email) . '</a>' . '</p>';
    }

    if (get_field('vice_ordforande_beskrivning')):
        the_field('vice_ordforande_beskrivning');
    endif;

    echo '<h2>Styrelse Sekreterare</h2>';
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Styrelse Sekreterare'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->user_email) . '">' . esc_html($user->user_email) . '</a>' . '</p>';
    }

    if (get_field('sekreterare_beskrivning')):
        the_field('sekreterare_beskrivning');
    endif;

    echo '<h2>Styrelse Kassör</h2>';
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Styrelse Kassör'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->user_email) . '">' . esc_html($user->user_email) . '</a>' . '</p>';
    }

    if (get_field('kassor_beskrivning')):
        the_field('kassor_beskrivning');
    endif;

    echo '<h2>Styrelse Personalansvarig</h2>';
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Styrelse Personalansvarig'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->user_email) . '">' . esc_html($user->user_email) . '</a>' . '</p>';
    }

    if (get_field('personalansvarig_beskrivning')):
        the_field('personalansvarig_beskrivning');
    endif;

    echo '<h2>Styrelse Suppleant 1</h2>';
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Styrelse Suppleant 1'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->user_email) . '">' . esc_html($user->user_email) . '</a>' . '</p>';
    }

    if (get_field('suppleant_1_beskrivning')):
        the_field('suppleant_1_beskrivning');
    endif;

    echo '<h2>Styrelse Suppleant 2</h2>';
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Styrelse Suppleant 2'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->user_email) . '">' . esc_html($user->user_email) . '</a>' . '</p>';
    }

    if (get_field('suppleant_2_beskrivning')):
        the_field('suppleant_2_beskrivning');
    endif;

    echo '<h2>Styrelse Suppleant 3</h2>';
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Styrelse Suppleant 3'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->user_email) . '">' . esc_html($user->user_email) . '</a>' . '</p>';
    }

    if (get_field('suppleant_3_beskrivning')):
        the_field('suppleant_3_beskrivning');
    endif;

    echo '<h2>Lekmannarevisor</h2>';
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Lekmannarevisor'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->user_email) . '">' . esc_html($user->user_email) . '</a>' . '</p>';
    }

    if (get_field('lekmannarevisor_beskrivning')):
        the_field('lekmannarevisor_beskrivning');
    endif;

    echo '<h2>Valberedning</h2>';
    $mont_users = get_users(array('orderby' => 'last_name', 'meta_key' => 'uppdrag', 'meta_value' => 'Valberedning'));
    foreach ($mont_users as $user) {
        echo '<p>' . esc_html($user->first_name) . ' ' . esc_html($user->last_name) . '<br />Tel. ' . '<a href="tel:' . esc_html($user->telnr) . '">' . esc_html($user->telnr) . '</a>' . '<br />' . '<a href="mailto:' . esc_html($user->user_email) . '">' . esc_html($user->user_email) . '</a>' . '</p>';
    }

    if (get_field('valberedning')):
        the_field('valberedning');
    endif;

    // Close Styrelsen page
} ?>


<?php wp_reset_query(); ?>


<?php
// ----------------------------------------
// Close ACF loop
    }
    // ----------------------------------------

    //* Run the Genesis loop

    genesis();
}
