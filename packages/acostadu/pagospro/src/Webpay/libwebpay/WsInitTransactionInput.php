<?php
namespace Acostadu\Pagos_pro\Webpay\libwebpay;
  
class WsInitTransactionInput {

    var $wSTransactionType; //wsTransactionType
    var $commerceId; //string
    var $buyOrder; //string
    var $sessionId; //string
    var $returnURL; //anyURI
    var $finalURL; //anyURI
    var $transactionDetails; //wsTransactionDetail
    var $wPMDetail; //wpmDetailInput

}
?>