<?php

namespace app\components;

//Father Controller

abstract class Controller
{
	/**
	 * Renders json formatted response
	 * @param $data
	 * @param $code
	 * @param $status
	 *
	 * @return string
	 */
	public function response($data, $code = 200, $status = 'ok')
	{
		return (new Response($data, $code, $status));
	}
}
