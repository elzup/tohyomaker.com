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
		$url = $path . (empty($parameters) ? "" : ('?' . http_build_query($parameters)));
		header('Location: ' . $url);
		exit;
	}

}



if (!function_exists('array_filter_values'))
{

	/**
	 * trim empty value and renumber keys
	 * @param array $array
	 * @return array result array
	 */
	function array_filter_values(array $array)
	{
		return array_values(array_filter($array, 'strlen'));
	}

}

if (!function_exists('h'))
{

	/**
	 * just htmlspecialchars action and return result
	 * omit function name in coding
	 * @param string $string
	 * @return string
	 */
	function h($string)
	{
		return htmlspecialchars($string);
	}
}