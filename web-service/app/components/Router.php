<?php

namespace app\components;

class Router
{
	public $controller;
	public $action;
	public $params;

	/**
	 * Router constructor.
	 *
	 * @param Request $request
	 *
	 * @throws RestException
	 */
	public function __construct(Request $request)
	{
		$this->setRoute($request);
	}

	/**
	 * Defines controller and action
	 *
	 * @param Request $request
	 *
	 * @throws RestException
	 */
	public function setRoute(Request $request)
	{
		$uri = $request->getURI();
		$routes = Config::get('routes');
		$method = $request->getMethod();
		if ($method == 'OPTIONS')
			throw new RestException('Options method?! Why do you do that?', RESPONSE::OK);

		$internalRoute = $this->matchRoute($uri, $routes, $method);
		if($internalRoute === Response::NOT_FOUND) {
			throw new RestException( 'Invalid route: ' . $uri, Response::NOT_FOUND);
		} else if ($internalRoute === Response::METHOD_NOT_ALLOWED) {
			throw new RestException( "Method {$method} is not allowed for {$uri}", RESPONSE::METHOD_NOT_ALLOWED );
		}

		// Defines controller & action. Also adds new params to _GET array (if transferred)
		$internalRoutePieces = explode('@', $internalRoute->internalRoute);
		$this->controller = $internalRoutePieces[0];
		$this->action = $internalRoutePieces[1];
		if ($this->params) $request->mergeGet($this->params);
	}

	/**
	 * Compares incoming uri with route names
	 * Also defines get params in uri and assigns it to self params
	 * @param $uri
	 * @param $routes
	 * @param $method
	 * @return array|bool|mixed
	 */
	public function matchRoute($uri, $routes, $method)
	{
		$invalidMethod = false;
		foreach ($routes as $route) {
			$regex = $this->formAlias($route->alias, $route->params);
			if(preg_match("#^{$regex}/?$#", $uri, $matches)) {
				if ($method !== $route->method) {
					$invalidMethod = true;
					continue;
				}

				array_shift($matches);
				// defines get params in uri and assigns it to self params
				if ($matches) {
					$matches = array_combine(array_keys($route->params), $matches);
					$this->params = $matches;
				}

				return $route;
			}
		}

		return $invalidMethod ? Response::METHOD_NOT_ALLOWED : Response::NOT_FOUND;
	}

	/**
	 * Replaces params (if they exists) in aliases to check if uri fits
	 * @param $alias
	 * @param $params
	 *
	 * @return mixed
	 */
	public function formAlias($alias, $params)
	{
		foreach ($params as $param => $value) {
			$alias = str_replace('{'. $param .'}', '('. $value .')', $alias);
		}

		return $alias;
	}

}