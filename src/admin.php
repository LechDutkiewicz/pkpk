<?php

namespace App;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});

add_action( 'show_user_profile', 'App\extra_user_profile_fields' );
add_action( 'edit_user_profile', 'App\extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { ?>
    <h3><?php _e("Extra profile information", "blank"); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="address"><?php _e("Address"); ?></label></th>
            <td>
                <input type="checkbox" name="report_on_email" id="report_on_email" value="yes" <?php if (esc_attr( get_the_author_meta( "report_on_email", $user->ID )) == "yes") echo "checked"; ?> /><label for="report_on_email "><?php _e("My Field"); ?></label><br />
                <span class="description"><?php _e("Please enter your address."); ?></span>
            </td>
        </tr>
    </table>
<?php }

add_action( 'personal_options_update', 'App\save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'App\save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
    update_user_meta( $user_id, 'report_on_email', $_POST['report_on_email'] );
}

if( function_exists('acf_add_options_page') ) {   
    acf_add_options_page(array(
        'page_title' 	=> 'Główne opcje motywu',
        'menu_title'	=> 'Opcje motywu',
        'menu_slug' 	=> 'pkpk-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Kurs',
        'menu_title'	=> 'Kurs',
        'parent_slug'	=> 'pkpk-general-settings',
        'post_id'       => 'options-course',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Informacje o gwarancji zwrotu pieniędzy',
        'menu_title'    => 'Gwarancja zwrotu pieniędzy',
        'parent_slug'   => 'pkpk-general-settings',
        'post_id'       => 'options-warranty',
    ));
}

/*============================================================
=            Custom columns for users admin panel            =
============================================================*/

function new_modify_user_table( $column ) {
    $column['raport'] = 'Raporty';
    $column['kursy'] = 'Kursy';

    unset( $column['email'] );
    return $column;
}
add_filter( 'manage_users_columns', 'App\new_modify_user_table' );

function new_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'raport' :

        $user_info = get_userdata($user_id);

        ob_start();
        ?>
        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#reportModal_<?= $user_id; ?>">Raporty</button>

        <div class="modal fade" id="reportModal_<?= $user_id; ?>" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title">Raport | <?= $user_info->user_email; ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <?= do_shortcode("[userreporting_all id=\"{$user_id}\"]"); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>
<?php

$return_string = ob_get_contents();
ob_end_clean();

return $return_string;
break;

case 'kursy':

$return_string = "";

global $wpdb;
// get payment ids for user from db
$results = $wpdb->get_results("SELECT `payment_ids` FROM `wp_edd_customers` WHERE `user_ID` LIKE '{$user_id}'");

$payment_ids = $results[0];

// get payment post type meta
$user_payment_meta = get_post_meta($payment_ids->payment_ids, '_edd_payment_meta');
// get user downloads from payment meta
$user_downloads = $user_payment_meta[0]['cart_details'];
// get course name from each download and combine as string
foreach ($user_downloads as $download) {
    $return_string .= $download['name'] .", ";
}

return $return_string;
break;

default:

}
return $val;
}
add_filter( 'manage_users_custom_column', 'App\new_modify_user_table_row', 10, 3 );

/*=====  End of Custom columns for users admin panel  ======*/
