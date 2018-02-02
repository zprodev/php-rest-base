<?php

$uri = trim($_SERVER['REQUEST_URI'], '/');
if(!$uri){
	http_response_code('400');
	exit;
}
$uris = explode('/', $uri);
$resource = $uris[0];

$className = ucfirst($resource.'Controller');
$classFilePath = dirname(__FILE__) . '/controller/' . $className . '.php';
if(!file_exists($classFilePath)){
	http_response_code('404');
	exit;
}

require_once( dirname(__FILE__).'/conf/const.php' );
require_once( dirname(__FILE__).'/controller/BaseController.php' );
require_once( $classFilePath );

$controller = new $className;

$controller->receiveRequest();
