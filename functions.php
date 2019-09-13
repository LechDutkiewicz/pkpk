<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

show_admin_bar(false);

// uncomment to enable error reporting
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('5.6.4', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 5.6.4 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "src/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin', 'post-types', 'metaboxes', 'rest', 'course-app', 'make-pdf', 'lib/edd-overrides/tpayLibs/src/_class_tpay/PaymentForms/pkpkpaymentform', 'pkpk-edd', 'shortcodes']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/templates
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage
 *
 * We do this so that the Template Hierarchy will look in themes/sage/templates for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/templates
 */
if (is_customize_preview() && isset($_GET['theme'])) {
    $sage_error(__('Theme must be activated prior to using the customizer.', 'sage'));
}
add_filter('template', function ($stylesheet) {
    return dirname($stylesheet);
});
if (basename($stylesheet = get_option('template')) !== 'templates') {
    update_option('template', "{$stylesheet}/templates");
    wp_redirect($_SERVER['REQUEST_URI']);
    exit();
}
add_filter('tml_template_paths', function() {
  return array(TEMPLATEPATH);
});

// =========================================================================
// REMOVE JUNK FROM HEAD
// =========================================================================
remove_action('wp_head', 'rsd_link'); // remove really simple discovery link
remove_action('wp_head', 'wp_generator'); // remove wordpress version

remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links

remove_action('wp_head', 'index_rel_link'); // remove link to index page
remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)

remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );

/*
add_action( 'init', function() {
  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  //add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
} );
*/


add_action( 'wp_ajax_download_certificate', 'download_certificate' );
add_action( 'wp_ajax_nopriv_download_certificate', 'download_certificate' );


function download_certificate() {
    // check if user is logged in, if not redirect to login page
    if (! is_user_logged_in() ) {
        auth_redirect();
    } else {
        $user = get_current_user_id();
        $user_id = $user->ID;
    }

    // $user_id = $_GET['id'];
    $course = $_GET['course'];
    //$my_nonce = $_GET['nonce'];

    if (! is_numeric($course)) {
      wp_die('ID must be integer, my dear.');
  }

    // $action = 'download_certificate_' . ($user_id * $course);
    //
    // if ( !isset($my_nonce) || !wp_verify_nonce($my_nonce, $action) ) {
    //   wp_die('Security check.');
    // }

  $restricted_to = get_field('course_download', $course);

  if (empty($restricted_to)) {
      wp_die('This course does not exist.');
  }

  $payments = App\get_payments_user_meta( $restricted_to );
    //print_r($payments);
  $final_user = '';

  foreach($payments as $payment) {
        // check if user exist
    $user = get_userdata( $payment['id'] );
    if ( $user !== false ) {
            //user id does exist
        if ( !empty($payment['first_name']) && !empty($payment['last_name'] ) ) {
          if ( $user_id == $payment['id'] ) {
            $final_user = $payment;
        }
              //print_r($user_id);
    } else {
              // we have to ask user for first name or last name
    }
}
}

if ( empty($final_user) ) {
    $user = wp_get_current_user();
    $final_user['first_name'] = $user->user_firstname;
    $final_user['last_name'] = $user->user_lastname;
    $final_user['id'] = $user->ID;
}

$course_end = get_field('course_end', $course, false);

$upload = wp_upload_dir();
$upload_dir = $upload['basedir'];
$upload_dir = $upload_dir . '/pkpk-courses/course-' . $course . '/certificates';

if( ! wp_mkdir_p($upload_dir) ) {
    wp_mkdir_p($upload_dir);
}

$filename = $final_user['id'] . ' ' . $final_user['first_name'] . ' ' . $final_user['last_name'] .'.pdf';
$filename = remove_accents($filename);
$filename = str_replace(' ', '-', $filename);
$file = $upload_dir . '/' . $filename;

    if(! file_exists($file) ) { // file does not exist
        App\makePDF($final_user, $course_end, $upload_dir);
    }

    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Type: application/pdf");
    header("Content-Transfer-Encoding: binary");

    // read the file from disk
    readfile($file);
}

/*----------  Keep users logged in for 5 days  ----------*/


// add_filter ( 'auth_cookie_expiration', 'user_login_session' );

function user_login_session( $expire ) { // Set login session limit in seconds
    // return YEAR_IN_SECONDS;
    // return MONTH_IN_SECONDS;
    return DAY_IN_SECONDS * 5;
    // return HOUR_IN_SECONDS;
}

// sort comments compatible with WP Ulike plugin
// solution: https://wordpress.stackexchange.com/questions/16676/sort-comments-by-karma
// plugin: https://wordpress.org/support/plugin/wp-ulike/
function comment_comparator($a, $b) {
    $compared = 0;
    $comments_a = get_comment_meta( $a->comment_ID, '_commentliked', true );
    $comments_b = get_comment_meta( $b->comment_ID, '_commentliked', true );

    if($comments_a != $comments_b)
    {
        $compared = $comments_a < $comments_b ? 1:-1;
    }
    return $compared;
}

