<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/webpay', 'WebpayController@index');

Route::get('/normal', 'TbkNormalController@index');

//Prueba Webservice SOAP
Route::get('/prueba/tiempo', function() {

	//echo Config::get('cert.environment');
	/*
	$opts = array(
		'ssl' => array('ciphers'=>'RD4-SHA', 'verify_peer'=>false, 'verify_peer_name'=>false)
	);

	$params = array('encoding'=>'UTF-8', 'verifypeer'=>false, 'verifyhost'=>false, 'soap_version'=>SOAP_1_2);
	$url = "http://wwww.webservicex.net/globalweather.asmx?WSDL";

	try {
		$client = new SoapClient($url, $params);
		dd($client->__getTypes());
	}
	catch (SopaFault $fault) {
		echo '<br>'.$fault;
	}
	*/
});
