<?php

/*
 * application/helpers/functions.php
 */

if (!function_exists('jump'))
{

	function jump($path, $parameters = null)
	{
		$url = $path . "?" . (empty($parameters) ? "" : http_build_query($parameters));
		header('Location: ' . $url);
		exit;
	}

}



if (!function_exists('set_token'))
{

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
