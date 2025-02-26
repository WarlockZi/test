<?php


namespace app\core;


class Error
{
	protected static $errors = [];

	public static function setError($error)
	{
		self::$errors[] = $error;
	}

	public static function getErrors()
	{
		return self::$errors;
	}

	public static function getErrorHtml()
	{
		if (!count(self::$errors)) return '';

		$html = '';
		foreach (self::$errors as $error) {
			$html .= "<div class='message error'>{$error}</div>";
		}
		return "<div class='errors'>{$html}</div>";

	}


}