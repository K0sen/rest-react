<?php

namespace app\components;

class App
{
	/**
	 * Runs app
	 * @param $config
	 */
	public function run($config)
	{
		try {
			Config::init($config);
			$request = new Request();
			$router = new Router($request);

			//define controller and action through route
			$controller = '\app\controllers\\'.$router->controller;
			$action = $router->action;

			//run action of certain controller
			$controller = new $controller();
			$response = $controller->$action($request);

		} catch (RestException $e) {
			$response = new Response($e->getMessage(), $e->getCode(), 'error');
		} catch(\Exception $e) {
			$code = http_response_code();
			$response = new Response($e->getMessage(), $code, 'error');
		}

		//display a content
		echo $response;
	}
}