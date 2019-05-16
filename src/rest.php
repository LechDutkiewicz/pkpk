<?php

add_action( 'rest_api_init', function () {
  register_rest_route( 'pkpk/v1', '/pricetable/', array(
    'methods' => 'GET',
    'callback' => 'pkpk_pricetable_rest',
  ) );
} );

/**
 * Grab latest post title by an author!
 *
 * @param array $data Options for the function.
 * @return string|null Post title for the latest,  * or null if none.
 */
function pkpk_pricetable_rest( $data ) {
  return pkpk_future_courses();
}
