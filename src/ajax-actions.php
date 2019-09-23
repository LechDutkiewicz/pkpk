<?php

function autosave_raport() {

	if ( !isset( $_POST ) || empty( $_POST ) ) {
		$return_data['value'] = __( 'Cannot send email to destination. No parameter receive form AJAX call.', 'bon' );
		die( json_encode( $return_data ) );

	} else {

		$lesson_id = $_POST['post_id'];
		$userID = $_POST['user_id'];

		// pobierz raporty dla danej lekcji
		$reports = get_post_meta( $lesson_id, 'prod_userreporting_reports', true );

		if ( !is_array($reports) ) {
			$reports = [];
		}

		$raportEntry = [];

		// set timezone
		date_default_timezone_set('Europe/Warsaw');
		$now = date("Y-m-d H:i:s");
		$reportEntry['createdAt'] = $now;

		if ( $lesson_id ) {

			$fields = get_post_meta( $lesson_id, 'prod_userreporting_fields', true );

			// zapisz do BD wartości pól z raportu
			if ($fields) {
				foreach ($fields as $name => $field) {
					if ($field['type'] == 'longtext') {
						$reportEntry[$name] = sanitize_textarea_field($_POST[$name]);
					} else {
						$reportEntry[$name] = sanitize_text_field($_POST[$name]);
					}
				}
			}

			// dodaj informację, że jest to wersja robocza
			$reportEntry['wersja'] = 'robocza';

			$reports[$userID] = $reportEntry;
			update_post_meta( $lesson_id, 'prod_userreporting_reports', $reports) ;

		}
		die();

	}

}

add_action( 'wp_ajax_autosave-raport', 'autosave_raport' );
add_action( 'wp_ajax_nopriv_autosave-raport', 'autosave_raport' );

?>