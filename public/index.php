<?php

error_reporting(E_ALL);

use Phalcon\Mvc\Micro as App; 

define ('APP_PATH', realpath('../app'));

require APP_PATH . '/config/loader.php';
require APP_PATH . '/config/services.php';

try {
//

	//Variable sd configuracion
	$url = "http://10.0.0.121/dark_moon_Phalcon/server_test/apitemp.php";
	$separador = ";";
 
	$app = new App();
	
	/**
	 * Return a coordinates by a file initial
	 * $param string $type Example: file, rest   
	 */
	$app->get('/coordinates', function() use ($url) {
		$content = file_get_contents($url);

		// Prepend a base path if Predis is not available in your "include_path".
		require '../app/library/Predis/autoload.php';
		Predis\Autoloader::register();

		$client = new Predis\Client();

		$client->lpush('last', $content);

		$val = $client->lrange('last', 0, -1);
		print_r($val);
	});

	/**
	 * Return a coordinates by a file initial
	 * $param string $type Example: file, rest   
	 */
	$app->get('/lastCoordinate', function() use ($url) {
		// Prepend a base path if Predis is not available in your "include_path".
		require '../app/library/Predis/autoload.php';
		Predis\Autoloader::register();

		$client = new Predis\Client();

		$val = $client->lrange('last', -1, -1);
		echo $val[0];
	});

	/**
	 * Return a coordinates by a file initial
	 * $param string $type Example: file, rest   
	 */
	$app->get('/randCoordinate', function() use ($url) {
		// Prepend a base path if Predis is not available in your "include_path".
		require '../app/library/Predis/autoload.php';
		Predis\Autoloader::register();

		$client = new Predis\Client();

		$val = $client->lrange('last', rand(1,1000)*-1, -1);
		echo $val[0];
	});	

	$app->handle();

} catch (Exception $e) {
	echo $e->getMessage();
}