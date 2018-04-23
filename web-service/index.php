<?php

ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);
// TODO find a right place for headers && composer
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
//require(__DIR__.'/vendor/autoload.php');

spl_autoload_register(function ($class) {
	$file = __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';
    if (!file_exists($file)) {
        throw new \Exception("{$file} not found", 404);
    }

	require_once($file);
});

$config = require( __DIR__ . '/config/config.php' );

(new app\components\App())->run($config);