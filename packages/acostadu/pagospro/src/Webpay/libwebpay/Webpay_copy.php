<?php

namespace Acostadu\Pagos_pro\Webpay\libwebpay;

use Acostadu\Pagos_pro\Webpay\libwebpay\Configuration;

/**
* @category   Plugins/SDK
* @author     Allware Ltda. (http://www.allware.cl)
* @copyright  2018 Transbank S.A. (http://www.transbank.cl)
* @date       May 2018
* @license    GNU LGPL
* @version    2.0.4
* @link       http://transbankdevelopers.cl/
 */

require_once(__DIR__ . '/soap/soap-wsse.php');
require_once(__DIR__ . '/soap/soap-validation.php');
require_once(__DIR__ . '/soap/soapclient.php');

//include('configuration.php');
include('webpay-normal.php');
include('webpay-mall-normal.php');
include('webpay-nullify.php');
include('webpay-capture.php');
include('webpay-oneclick.php');
include('webpay-complete.php');

class Webpay {

    var $configuration, $webpayNormal, $webpayMallNormal, $webpayNullify, $webpayCapture, $webpayOneClick, $webpayCompleteTransaction;

    function __construct($params) {

        $this->configuration = $params;
    }

    public function test() {
        return 'Esto es una prueba de Librerias Webpay';
    }    

    public function getNormalTransaction() {
        if ($this->webpayNormal == null) {
            $this->webpayNormal = new WebPayNormal($this->configuration);
        }
        return $this->webpayNormal;
    }

    public function getMallNormalTransaction() {
        if ($this->webpayMallNormal == null) {
            $this->webpayMallNormal = new WebPayMallNormal($this->configuration);
        }
        return $this->webpayMallNormal;
    }

    public function getNullifyTransaction() {
        if ($this->webpayNullify == null) {
            $this->webpayNullify = new WebpayNullify($this->configuration);
        }
        return $this->webpayNullify;
    }

    public function getCaptureTransaction() {
        if ($this->webpayCapture == null) {
            $this->webpayCapture = new WebpayCapture($this->configuration);
        }
        return $this->webpayCapture;
    }

    public function getOneClickTransaction() {
        if ($this->webpayOneClick == null) {
            $this->webpayOneClick = new WebpayOneClick($this->configuration);
        }
        return $this->webpayOneClick;
    }

    public function getCompleteTransaction() {
        if ($this->webpayCompleteTransaction == null) {
            $this->webpayCompleteTransaction = new WebpayCompleteTransaction($this->configuration);
        }
        return $this->webpayCompleteTransaction;
    }

}

class baseBean {

}

class getTransactionResult {

    var $tokenInput; //string

}

class getTransactionResultResponse {

    var $return; //transactionResultOutput

}
