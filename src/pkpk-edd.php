<?php

/*

  Override tpay Gateway Easy Digital Download functions

 */

use tpayLibs\EDD\BasicPaymentForm;
use tpayLibs\EDD\TpayAdminSettings;
use tpayLibs\EDD\TransactionNotification;
use tpayLibs\src\_class_tpay\Utilities\Lang;
use tpayLibs\PKPK;

// uncomment to enable error reporting
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', '1');

// proces platnosci
function pkpk_transferuj_process_payment($purchase_data)
{
    load_libs();
    global $edd_options;

// check there is a gateway name
    if (!isset($purchase_data['post_data']['edd-gateway'])) {
        return;
    }

    // collect payment data
    $payment_data = array(
        'price'        => $purchase_data['price'],
        'date'         => $purchase_data['date'],
        'user_email'   => $purchase_data['user_email'],
        'purchase_key' => $purchase_data['purchase_key'],
        'currency'     => $edd_options['currency'],
        'downloads'    => $purchase_data['downloads'],
        'user_info'    => $purchase_data['user_info'],
        'cart_details' => $purchase_data['cart_details'],
        'status'       => 'pending'
    );
    $errors = edd_get_errors();

    if ($errors) {
        // return the errors if any
        edd_send_back_to_checkout('?payment-mode=' . $purchase_data['post_data']['edd-gateway'] . '&purchase-value=' . $purchase_data['price']);
    } else {

        $payment = edd_insert_payment($payment_data);

        // check the payment
        if (!$payment) {

            edd_send_back_to_checkout('?payment-mode=' . $purchase_data['post_data']['edd-gateway'] . '&purchase-value=' . $purchase_data['price']);
        } else {
            $id = (int)$edd_options['transferuj_merchantid'];
            $code = $edd_options['transferuj_secretpass'];
            $terms = (isset($_POST['regulamin']) && $_POST['regulamin'] == 1) ? true : false;
            $ordernumber = str_pad($payment, 4, 0, STR_PAD_LEFT);

            $returnUrl = add_query_arg(array(
                'payment-confirmation'  => 'transferuj',
                'purchase-value'        => $purchase_data['price'],
            ),get_permalink($edd_options['success_page']));

            $returnUrlError = add_query_arg(array(
                'payment-confirmation'  => 'transferuj',
                'purchase-value'        => $purchase_data['price'],
            ),get_permalink($edd_options['failure_page']));
            
            $params = array(
                'kwota'        => $purchase_data['price'],
                'nazwisko'     => $purchase_data['user_info']['first_name'] . ' ' . $purchase_data['user_info']['last_name'],
                'email'        => $purchase_data['user_info']['email'],
                'crc'          => base64_encode($ordernumber),
                'opis'         => 'Zamówienie nr: ' . $ordernumber,
                'wyn_url'      => $returnUrl,
                'pow_url'      => $returnUrl,
                'pow_url_blad' => $returnUrlError,
            );
            if ($terms) {
                $params['akceptuje_regulamin'] = 1;
            }
            if (isset($_POST['kanal']) && (int)$_POST['kanal'] > 0) {
                $params['kanal'] = (int)$_POST['kanal'];
            }

            (new PKPK\PkpkPaymentForm($id, $code))->pkpkDataForTpay($params);

            edd_empty_cart();

        }
    }
}

remove_action('edd_gateway_transferuj', 'transferuj_process_payment');
add_action('edd_gateway_transferuj', 'pkpk_transferuj_process_payment');