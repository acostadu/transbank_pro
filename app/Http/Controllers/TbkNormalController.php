<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Acostadu\Pagos_pro\Webpay\libwebpay\Webpay;
use Acostadu\Pagos_pro\Webpay\libwebpay\Configuration;
//use Acostadu\Pagos_pro\Lib\Dog;

class TbkNormalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $certificate = [
            "environment" => "INTEGRACION", /** Ambiente */
            'private_key' => storage_path().'\app\public\certificates\597020000541.key', /** Llave Privada */
            "public_cert" => storage_path().'\app\public\certificates\597020000541.crt', /** Certificado Público */
            "webpay_cert" => storage_path().'\app\public\certificates\tbk.pem', /** Certificado Privado */
            "commerce_code" => "597020000541" /** Codigo Comercio */
        ];

        $configuration = new Configuration();
        $configuration->setEnvironment($certificate['environment']); //\Config::get('cert.environment')
        $configuration->setCommerceCode($certificate['commerce_code']); //\Config::get('cert.commerce_code')
        $configuration->setPrivateKey($certificate['private_key']); //\Config::get('cert.private_key')
        $configuration->setPublicCert($certificate['public_cert']); //\Config::get('cert.public_cert')
        $configuration->setWebpayCert($certificate['webpay_cert']); //\Config::get('cert.webpay_cert')

        /** Configuracion parametros de la clase Webpay */
        $sample_baseurl = \Request::fullUrl(); //$_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

        /** Creacion Objeto Webpay */
        //dd($configuration);
        $webpay = new Webpay($configuration);

        $action = isset($_GET["action"]) ? $_GET["action"] : 'init';
        $post_array = false;

        switch ($action) {

            default:

                $tx_step = "Init";

                /** Monto de la transacción */
                $amount = 9990;

                /** Orden de compra de la tienda */
                $buyOrder = rand();

                /** Código comercio de la tienda entregado por Transbank */
                $sessionId = uniqid();

                /** URL de retorno */
                $urlReturn = $sample_baseurl."?action=getResult";

                /** URL Final */
                $urlFinal  = $sample_baseurl."?action=end";

                $request = array(
                    "action"    => $action,
                    "amount"    => $amount,
                    "buyOrder"  => $buyOrder,
                    "sessionId" => $sessionId,
                    "urlReturn" => $urlReturn,
                    "urlFinal"  => $urlFinal,
                );
                //dd($request);
                /** Iniciamos Transaccion */
                $result = $webpay->getNormalTransaction()->initTransaction($amount, $buyOrder, $sessionId, $urlReturn, $urlFinal);
                //dd($result);

                /** Verificamos respuesta de inicio en webpay */
                if (!empty($result->token) && isset($result->token)) {
                    $message = "Sesion iniciada con exito en Webpay";
                    $token = $result->token;
                    $next_page = $result->url;
                } else {
                    $message = "webpay no disponible";
                }

                $button_name = "Continuar &raquo;";

                break;

            case "getResult":

                $tx_step = "Get Result";

                if (!isset($_POST["token_ws"]))
                    break;

                /** Token de la transacción */
                $token = filter_input(INPUT_POST, 'token_ws');

                $request = array(
                    "token" => filter_input(INPUT_POST, 'token_ws')
                );

                /** Rescatamos resultado y datos de la transaccion */
                $result = $webpay->getNormalTransaction()->getTransactionResult($token);

                /** Verificamos resultado  de transacción */
                if ($result->detailOutput->responseCode === 0) {

                    /** propiedad de HTML5 (web storage), que permite almacenar datos en nuestro navegador web */
                    echo '<script>window.localStorage.clear();</script>';
                    echo '<script>localStorage.setItem("authorizationCode", '.$result->detailOutput->authorizationCode.')</script>';
                    echo '<script>localStorage.setItem("amount", '.$result->detailOutput->amount.')</script>';
                    echo '<script>localStorage.setItem("buyOrder", '.$result->buyOrder.')</script>';

                    $message = "Pago ACEPTADO por webpay (se deben guardatos para mostrar voucher)";
                    $next_page = $result->urlRedirection;

                } else {
                    $message = "Pago RECHAZADO por webpay - " . utf8_decode($result->detailOutput->responseDescription);
                    $next_page = '';
                }

                $button_name = "Continuar &raquo;";

                break;

            case "end":

                $post_array = true;

                $tx_step = "End";
                $request = "";
                $result = $_POST;

                $message = "Transacion Finalizada";
                $next_page = $sample_baseurl."?action=nullify";
                $button_name = "Anular Transacci&oacute;n &raquo;";

                break;

            case "nullify":

                $tx_step = "nullify";

                $request = $_POST;

                /** Codigo de Comercio */
                $commercecode = null;

                /** Código de autorización de la transacción que se requiere anular */
                $authorizationCode = filter_input(INPUT_POST, 'authorizationCode');

                /** Monto autorizado de la transacción que se requiere anular */
                $amount =  filter_input(INPUT_POST, 'amount');

                /** Orden de compra de la transacción que se requiere anular */
                $buyOrder =  filter_input(INPUT_POST, 'buyOrder');

                /** Monto que se desea anular de la transacción */
                $nullifyAmount = 200;

                $request = array(
                    "authorizationCode" => $authorizationCode, // Código de autorización
                    "authorizedAmount" => $amount, // Monto autorizado
                    "buyOrder" => $buyOrder, // Orden de compra
                    "nullifyAmount" => $nullifyAmount, // idsession local
                    "commercecode" => $configuration->getCommerceCode(), // idsession local
                );

                $result = $webpay->getNullifyTransaction()->nullify($authorizationCode, $amount, $buyOrder, $nullifyAmount, $commercecode);

                /** Verificamos resultado  de transacción */
                if (!isset($result->authorizationCode)) {
                    $message = "webpay no disponible";
                } else {
                    $message = "Transaci&oacute;n Finalizada";
                }

                $next_page = '';

                break;
        }

        echo "<h2>Step: " . $tx_step . "</h2>";

        if (!isset($request) || !isset($result) || !isset($message) || !isset($next_page)) {

            $result = "Ocurri&oacute; un error al procesar tu solicitud";
            echo "<div style = 'background-color:lightgrey;'><h3>result</h3>$result;</div><br/><br/>";
            echo "<a href='.'>&laquo; volver a index</a>";
            die;
        }

        return $request;       

        //return $request;
        //return currentUser();
        
        //$x = new Dog();
        //return $x->says();
    }    
}
