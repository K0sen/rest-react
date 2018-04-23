<?php

namespace app\components;

class Config
{
	public static $elements = array();

	/**
	 * Initializes config. Params takes from config/config.php
	 * @param $config
	 */
	public static function init($config)
	{
		self::$elements = $config;
	}

	/**
	 * @return array
	 */
	public static function get($key)
	{
		if (isset(self::$elements[$key])) {
			return self::$elements[$key];
		}

		return null;
	}

	/**
	 * @param array $elements
	 */
	public static function set($name, $element)
	{
		self::$elements[$name] = $element;
	}

}