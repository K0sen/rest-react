<?php

namespace app\components;

// Forms response

class Response
{
	const METHOD_NOT_ALLOWED = 405;
	const NOT_FOUND = 404;
	const OK = 200;
	const BAD_REQUEST = 400;
	const ALREADY_EXISTS = 409;
	const NO_CONTENT = 204;

	public $status;
	public $body;
	public $code;

	public function __construct($body, $code = self::OK, $status = 'ok')
	{
		$this->body = $body;
		$this->code = $code;
		$this->status = $status;
		$this->setHeaderCode($this->code);
	}

	public function __toString()
	{
		return json_encode([
			'status' => $this->status,
			'code' => $this->code,
			'body' => $this->body
		]);
	}

	public function setHeaderCode($code)
	{
		http_response_code($code);
	}
}