<?php
namespace Acostadu\Pagos_pro\Webpay\libwebpay;

use Acostadu\Pagos_pro\Webpay\libwebpay\soap\WSSESoap;
use Acostadu\Pagos_pro\Webpay\libwebpay\soap\SoapValidation;
//use Acostadu\Pagos_pro\Webpay\libwebpay\soap\WSSecuritySoapClient;

//use Acostadu\Pagos_pro\Webpay\libwebpay\Configuration;
use Acostadu\Pagos_pro\Webpay\libwebpay\WebpayNormal;

use Acostadu\Pagos_pro\Webpay\libwebpay\BaseBean;
use Acostadu\Pagos_pro\Webpay\libwebpay\GetTransactionResult;
use Acostadu\Pagos_pro\Webpay\libwebpay\getTransactionResultResponse;




/**
* @category   Plugins/SDK
* @author     Allware Ltda. (http://www.allware.cl)
* @copyright  2018 Transbank S.A. (http://www.transbank.cl)
* @date       May 2018
* @license    GNU LGPL
* @version    2.0.4
* @link       http://transbankdevelopers.cl/
 */

//require_once(__DIR__ . '/soap/WSSESoap.php');
//require_once(__DIR__ . '/soap/SoapValidation.php');
//require_once(__DIR__ . '/soap/WSSecuritySoapClient.php');

//include('Configuration.php');
//include('WebpayNormal.php');
//include('WebpayMallNormal.php');
//include('WebpayNullify.php');
//include('WebpayCapture.php');
//include('WebpayOneclick.php');
//include('WebpayComplete.php');

//include('BaseBean.php');
//include('GetTransactionResult.php');
//include('getTransactionResultResponse.php');

class Webpay {

    var $configuration, $webpayNormal, $webpayMallNormal, $webpayNullify, $webpayCapture, $webpayOneClick, $webpayCompleteTransaction;

    function __construct($params) {

        $this->configuration = $params;
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