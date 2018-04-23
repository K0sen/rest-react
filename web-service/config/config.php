<?php

$routes = include(__DIR__.'/routes.php');
$db = include(__DIR__.'/db.php');

return [
	'db' => $db,
	'routes' => $routes,
];