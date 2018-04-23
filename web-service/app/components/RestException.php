<?php

namespace app\components;


class RestException extends \Exception
{
	/**
	 * RestException constructor.
	 * @param string $message
	 * @param int $code
	 */
	public function __construct($message = 'Server Error', $code = 500)
	{
		parent::__construct($message, $code);
	}
}