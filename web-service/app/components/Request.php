<?php

namespace app\components;

//Wrapper class for requests

class Request
{
	private $get;
	private $post;
	private $server;
	private $files;

	/**
	 * Request constructor.
	 */
	public function __construct()
	{
		$this->get = $_GET;
		$this->post = $_POST;
		$this->server = $_SERVER;
		$this->files = $_FILES;
	}

	/**
	 * @param $key
	 * @return null
	 */
	public function get($key)
	{
		if (isset($this->get[$key])) {
			return $this->get[$key];
		}

		return null;
	}

	/**
	 * @param $key
	 * @return null
	 */
	public function post($key)
	{
		if (isset($this->post[$key])) {
			return $this->post[$key];
		}

		return null;
	}

	/**
	 * Checks request method
	 * @return bool
	 */
	public function getMethod()
	{
		return strtoupper($this->server('REQUEST_METHOD'));
	}

	/**
	 * @param $key
	 * @return null
	 */
	public function server($key)
	{
		if (isset($this->server[$key])) {
			return $this->server[$key];
		}

		return null;
	}

	/**
	 * @param $key
	 * @return null
	 */
	public function files($key)
	{
		if (isset($this->files[$key])) {
			return $this->files[$key];
		}

		return null;
	}


	/**
	 * @return mixed
	 */
	public function getURI()
	{
		$uri = $this->server('REQUEST_URI');
		$uri = explode('?', $uri);
		return $uri[0];
	}

	/**
	 * Add parameters to _GET
	 * @param array $params
	 */
	public function mergeGet(array $params)
	{
		$this->get += $params;
		$_GET += $params;
	}
}