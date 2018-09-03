<?php
namespace Acostadu\Pagos_pro\Webpay\libwebpay\soap;

use SoapClient;
use DOMDocument;

use Acostadu\Pagos_pro\Webpay\libwebpay\soap\XMLSecurityKey;
use Acostadu\Pagos_pro\Webpay\libwebpay\soap\XMLSecurityDSig;
use Acostadu\Pagos_pro\Webpay\libwebpay\soap\XMLSecEnc;
use Acostadu\Pagos_pro\Webpay\libwebpay\soap\WSSESoap;


//require_once('xmlseclibs.php');
//require_once('XMLSecurityKey.php');
//require_once('XMLSecurityDSig.php');
//require_once('XMLSecEnc.php');
//require_once('WSSESoap.php');

class WSSecuritySoapClient extends SoapClient {
    
    private $useSSL = false;
    private $privateKey = "";
    private $publicCert = "";

    function __construct($wsdl, $privateKey, $publicCert, $options) {
        
        $locationparts = parse_url($wsdl);
        $this->useSSL = $locationparts['scheme'] == "https" ? true : false;
        $this->privateKey = $privateKey;
        $this->publicCert = $publicCert;

        //dd($this->privateKey);

        return parent::__construct($wsdl, $options);
    }

    function __doRequest($request, $location, $saction, $version, $one_way = 0) {
        //dd($request);
        if ($this->useSSL) {
            $locationparts = parse_url($location);
            $location = 'https://';
            if (isset($locationparts['host']))
                $location .= $locationparts['host'];
            if (isset($locationparts['port']))
                $location .= ':' . $locationparts['port'];
            if (isset($locationparts['path']))
                $location .= $locationparts['path'];
            if (isset($locationparts['query']))
                $location .= '?' . $locationparts['query'];
        }
        $doc = new DOMDocument('1.0');

        $doc->loadXML($request);
        $objWSSE = new WSSESoap($doc);
        $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array(
            'type' => 'private'
        ));

        /** False para cargar en modo texto, true para archivo */
        $objKey->loadKey($this->privateKey, TRUE, TRUE); // FALSE, FALSE
        $options = array(
            "insertBefore" => TRUE
        );
        $objWSSE->signSoapDoc($objKey, $options);
        $objWSSE->addIssuerSerial($this->publicCert);
        $objKey = new XMLSecurityKey(XMLSecurityKey::AES256_CBC);
        $objKey->generateSessionKey();
        $retVal = parent::__doRequest($objWSSE->saveXML(), $location, $saction, $version);

        $doc = new DOMDocument();
        $doc->loadXML($retVal);
        
        return $doc->saveXML();
    }

}

?>
