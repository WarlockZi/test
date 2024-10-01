<?php

namespace app\controller\Admin;

use app\controller\AppController;

class LogisticController extends AppController
{

	public function __construct()
	{
		parent::__construct();

	}

	public function actionKey(){
		$key = '74ca418bbf3c680227905417d3f17589';
	}

	public function actionIndex():void
	{
		$myCurl = curl_init();

		$user = "89115440126";
		$pass="EMR1510";

		$url='https://test-api.baikalsr.ru/v2/order/list';
		$url='https://test-api.baikalsr.ru/v2/directory/cargotype';

		$user64 = "NWIwNGI4OGUxODY1MzIzNDcxNTlmZTE0NDFkMGZmZjU=";
		$user = "5b04b88e186532347159fe1441d0fff5";
		$user = "74ca418bbf3c680227905417d3f17589";

		$pass="";
		$headers = array(
			'Content-Type:application/json',
			'Authorization: Basic ' . "5b04b88e186532347159fe1441d0fff5"
		);
		curl_setopt($myCurl, CURLOPT_HTTPHEADER, $headers);

		curl_setopt_array($myCurl, array(
			CURLOPT_URL => 'https://test-api.baikalsr.ru/v2/order/list',
//			CURLOPT_URL => 'https://baikalsr.ru/v2/order/list',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
			CURLOPT_USERPWD => "5b04b88e186532347159fe1441d0fff5",
//				CURLOPT_USERPWD => "89115440126:EMR1510",
//			CURLOPT_POSTFIELDS => http_build_query(array(/*здесь массив параметров запроса*/))
		));


		$response = curl_exec($myCurl);
		curl_close($myCurl);
		//	5b04b88e186532347159fe1441d0fff5
		//login 89115440126
		//pas EMR1510

		//POST https://test-api.baikalsr.ru/v2/order/list

	}

}


