<?php

if (!function_exists('set_token'))
{

	/**
	 * 
	 * @return string generated token
	 */
	function set_token()
	{
		$token = sha1(uniqid(mt_rand(), TRUE));
		$_SESSION['token'] = $token;
		return $token;
	}
}

if (!function_exists('check_token'))
{

	/**
	 * 
	 * @return string|bool token or fauld
	 */
	function check_token($token = NULL)
	{
		if (is_null($token))
		{
			$token = filter_input(INPUT_POST, 'token');
		}
		if (empty($_SESSION['token']) || ($_SESSION['token'] != $token))
		{
			return FALSE;
		}
		return $token;
	}

}
