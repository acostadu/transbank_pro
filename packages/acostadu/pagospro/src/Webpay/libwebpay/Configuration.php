<?php
namespace Acostadu\Pagos_pro\Webpay\libwebpay;

/**
* @category   Plugins/SDK
* @author     Allware Ltda. (http://www.allware.cl)
* @copyright  2018 Transbank S.A. (http://www.transbank.cl)
* @date       May 2018
* @license    GNU LGPL
* @version    2.0.4
* @link       http://transbankdevelopers.cl/
 */

class Configuration {

    private $environment;
    private $commerce_code;
    private $private_key;
    private $public_cert;
    private $webpay_cert;
    private $store_codes;

    function __construct() {
    }

    public function Configuration() {
    }

    public function getEnvironment() {
        return $this->environment;
    }

    public function setEnvironment($environment) {
        $this->environment = $environment;
    }

    public function getCommerceCode() {
        return $this->commerce_code;
    }

    public function setCommerceCode($commerce_code) {
        $this->commerce_code = $commerce_code;
    }

    public function getPrivateKey() {
        return $this->private_key;
    }

    public function setPrivateKey($private_key) 
    {
        /*if (is_readable($private_key)) {
            $pri_key = openssl_pkey_get_private(file_get_contents($private_key));
            $keyData = openssl_pkey_get_details($pri_key);
            $this->private_key = $keyData['key']; 
        } else {
            return 1;
        }*/
        $this->private_key = $private_key;
    }

    public function getPublicCert() {
        return $this->public_cert;
    }

    public function setPublicCert($public_cert) {
        /*if (is_readable($public_cert)) {
            $pub_key = openssl_pkey_get_public(file_get_contents($public_cert));
            $keyData = openssl_pkey_get_details($pub_key);
            $this->public_cert = $keyData['key'];  
        } else {
            
            return 1;
        }*/
        $this->public_cert = $public_cert;
    }

    public function getWebpayCert() {
        return $this->webpay_cert;
    }

    public function setWebpayCert($webpay_cert) {
        /*if (is_readable($webpay_cert)) {
            $pub_key = openssl_pkey_get_public(file_get_contents($webpay_cert));
            $keyData = openssl_pkey_get_details($pub_key);                    
            $this->webpay_cert = $webpay_cert;
        } else {
            return 1;
        }*/
        $this->webpay_cert = $webpay_cert;
    }

    public function setStoreCodes($store_codes) {
        $this->store_codes = $store_codes;
    }

    public function getStoreCodes() {
        return $this->store_codes;
    }

    public function getEnvironmentDefault() {
        $modo = $this->environment;
        if (!isset($modo) || $modo == "") {
            $modo = "INTEGRACION";
        }
        return $modo;
    }

}
