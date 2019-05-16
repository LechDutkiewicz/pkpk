<?php

/*
 * Created by startprogress.eu
 */

namespace tpayLibs\PKPK;

use tpayLibs\src\_class_tpay\PaymentOptions\BasicPaymentOptions;
use tpayLibs\src\_class_tpay\PaymentForms\PaymentBasicForms;
use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Utilities\Util;

include_once WP_PLUGIN_DIR . '/easy-digital-downloads-payment-gateway-transferujpl/includes/tpayLibs/EDD/loader.php';

class PkpkPaymentForm extends PaymentBasicForms
{
    /**
     * Path to template directory
     * @var string
     */
    private $templateDir = 'common/_tpl/';

    public function __construct($id, $secret)
    {
        $this->merchantSecret = $secret;
        $this->merchantId = $id;
        parent::__construct();
    }

    /**
     * Create HTML form for basic panel payment based on transaction config
     * More information about config fields @see FieldsConfigValidator::$panelPaymentRequestFields
     *
     * @param array $config transaction config
     *
     * @return string
     */
    public function pkpkGetTransactionForm($config)
    {
        $config = $this->prepareConfig($config);

        $data = array(
            static::ACTION_URL => $this->panelURL,
            static::FIELDS     => $config,
        );

        return $this->parseTemplate($this->templateDir . "paymentform", $data);
    }

    public function pkpkDataForTpay($params)
    {
        error_reporting(E_ALL);
        echo $this->pkpkGetTransactionForm($params);
    }

    public static function parseTemplate($templateFileName, $data = array()) {

        $templateDirectory = dirname(__FILE__) . '/../../';
        $buffer = false;

        if (ob_get_length() > 0) {
            $buffer = ob_get_contents();
            ob_clean();
        }
        ob_start();
        
        if (!file_exists($templateDirectory . $templateFileName . '.phtml')) {
            return '';
        }
        include_once $templateDirectory . $templateFileName . '.phtml';
        $parsedHTML = ob_get_contents();
        ob_clean();

        if ($buffer !== false) {
            ob_start();
            echo $buffer;
        }

        return $parsedHTML;
    }
}
