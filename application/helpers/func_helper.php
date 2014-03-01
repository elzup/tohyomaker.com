<?php

/*
 * application/helpers/functions.php
 */

if (!function_exists('jump'))
{

	/**
	 * 
	 * @param string $path target url
	 * @param array $parameters get request params in associative array
	 */
	function jump($path, $parameters = null)
	{
		$url = $path . "?" . (empty($parameters) ? "" : http_build_query($parameters));
		header('Location: ' . $url);
		exit;
	}
}


