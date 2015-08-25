<?php
	require_once("./vendor/autoload.php");
	require_once("./oracle/Oracle.php");

	$oracle = new Oracle();

	Slim\Slim::registerAutoloader();
	$app     = new \Slim\Slim();
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');

	$app->get('/', function(){
		global $oracle;
		return $oracle->get_root();
	});

	$app->get('/product', function(){
		global $oracle;
		return $oracle->get_product();
	});

	$app->get('/product/:id', function($id){
		global $oracle;
		return $oracle->get_product($id);
	});

	$app->post('/product', function(){
		global $oracle;
		$request = \Slim\Slim::getInstance()->request();
		$oracle->save_product($request->post());
	});

	$app->post('/product/:id', function($id){
		global $oracle;
		$request = \Slim\Slim::getInstance()->request();
		$oracle->save_product($request->post(), $id);
	});

	$app->delete('/product/:id', function($id){
		global $oracle;
		$oracle->delete_product($id);
	});

	$app->run();
?>