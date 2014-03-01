<?php

if (!function_exists('set_token'))
{

	/**
	 * 
	 * @return string|bool
	 */
	function set_token()
	{
		$token = sha1(uniqid(mt_rand(), true));
		$_SESSION['token'] = $token;
		return $token;
	}

}

if (!function_exists('check_token'))
{

	function check_token()
	{
		$token = $_POST['token'];
		if (empty($_SESSION['token']) || ($_SESSION['token'] != $_POST['token']))
		{
			echo "不正なPOST";
		}
		return $token;
	}

}
