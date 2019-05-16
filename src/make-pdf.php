<?php
namespace App;
use Imagick;
use ImagickDraw;
use ImagickPixel;
use EDD_Logging;

// uncomment to enable error reporting
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

function makePDF($user, $course_end, $upload_dir) {

  if (!extension_loaded('imagick')){
    echo 'imagick not installed';
    return;
  }

  if (! empty($user) ) {
    $user_id = $user['id'];
    $first_name = $user['first_name'];
    $last_name = $user['last_name'];
  } else {
    return;
  }

  $Imagick = new Imagick();
  $Imagick->setResolution(300,300);
  $asset_path = asset_path('images/cert-sample-podpisany.jpg');

  // change to this path on dev
  // $asset_path = 'P:/xampp/htdocs/produktywnosckrok/wp-content/themes/pkpk/assets/images/cert-sample-podpisany.jpg';
  
  $Imagick->readImage($asset_path);

  $width = $Imagick->getImageWidth();
  $height = $Imagick->getImageHeight();

  // put text in white box (really on canvas that has already been modified)
  $ImagickDraw = new ImagickDraw();

  $font_path = get_template_directory() . '/assets/fonts/montserrat/montserrat-medium-webfont.ttf';
  /* Font properties for text */
  $ImagickDraw->setFont($font_path);
  $ImagickDraw->setFontSize(72); // 10 * 300/72 = 42
  $ImagickDraw->setFillColor(new ImagickPixel('#343393'));
  $ImagickDraw->setStrokeAntialias(true);
  $ImagickDraw->setTextAntialias(true);
  $ImagickDraw->setTextAlignment(Imagick::ALIGN_CENTER);
  $ImagickDraw->setGravity(Imagick::GRAVITY_CENTER);

  // add user name text to canvas (pdf page)
  $Imagick->annotateImage(
    $ImagickDraw,
    $width / 2, // 1 * 300/72 = 4
    1306, // 10 * 300/72 = 42
    0,
    $first_name . ' ' . $last_name // do not use html.. strip tags and replace <br> with \n if you got the text rom an editable div. (which is what I'm doing)
  );

  // add course end date text to canvas (pdf page)

setlocale(LC_TIME, "pl_PL", "Polish_Poland", "pl.UTF-8", "pl_utf8");
  // format course end string
  $course_end_time = strtotime($course_end);
  $course_end_day = date('j', $course_end_time);
  $course_end_month = month_in_pl( date('n', $course_end_time) );
  $course_end_year = date('Y', $course_end_time);

  $course_end_string = "{$course_end_day} {$course_end_month} {$course_end_year}";

  $ImagickDraw->setFontSize(36); // 10 * 300/72 = 42
  $ImagickDraw->setFillColor(new ImagickPixel('#273f4b'));
  $ImagickDraw->setFontWeight(300);

  $Imagick->annotateImage(
    $ImagickDraw,
    $width / 2, // 1 * 300/72 = 4
    2650, // 10 * 300/72 = 42
    0,
    $course_end_string // do not use html.. strip tags and replace <br> with \n if you got the text rom an editable div. (which is what I'm doing)
  );

  $user_name = $first_name . ' ' . $last_name;
  $user_name = remove_accents($user_name);
  $user_name = str_replace(' ', '-', $user_name);
  $filename = $user_id . '-' . $user_name . '.pdf';
  return $Imagick->writeImage($upload_dir . '/' . $filename);
}

/**
 * Get an array of all the log IDs using the EDD Logging Class
 *
 * @return array if logs, null otherwise
 * @param $download_id Download's ID
*/
function get_log_ids( $download_id = '' ) {
	// Instantiate a new instance of the class
	$edd_logging = new EDD_Logging;
	// get logs for this download with type of 'sale'
  $args = array(
    'post_type'      => 'edd_log',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'log_type'       => false,
    'post_parent'    => $download_id,
    'log_type'       => 'sale'
  );

  $logs = $edd_logging->get_connected_logs( $args );
	// if logs exist
  if ( $logs ) {
		// create array to store our log IDs into
    $log_ids = array();
		// add each log ID to the array
    foreach ( $logs as $log ) {
     $log_ids[] = $log->ID;
   }
		// return our array
   return $log_ids;
 }

 return null;
}

/**
 * Get array of payment IDs
 *
 * @param int $download_id Download ID
 * @return array $payment_ids
*/
function get_payment_ids( $download_id = '' ) {
	// these functions are used within a class, so you may need to update the function call
	$log_ids = get_log_ids( $download_id );
	if ( $log_ids ) {
		// create $payment_ids array
		$payment_ids = array();
		foreach ( $log_ids as $id ) {
			// get the payment ID for each corresponding log ID
			$payment_ids[] = get_post_meta( $id, '_edd_log_payment_id', true );
		}

		// return our payment IDs
		return $payment_ids;
	}

	return null;
}

function get_payments_user_meta( $download_id = '' ) {

  $payment_ids = get_payment_ids( $download_id );

  if ( $payment_ids ) {
    $payments = [];

    foreach ($payment_ids as $payment) {
      $user_meta = edd_get_payment_meta_user_info($payment);
      $payments[] = $user_meta;
    }

    return $payments;
  }

  return null;
}
