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
		$url = ($path ? : '') . (empty($parameters) ? "" : ('?' . http_build_query($parameters)));
		header('Location: ' . $url);
		exit;
	}

}

if (!function_exists('is_numonly'))
{

	function is_numonly($value)
	{
		return preg_match("/^\d+$/", $value);
	}

}

if (!function_exists('urlencode_array'))
{

	function urlencode_array(array $strs)
	{
		$encodeds = array();
		foreach ($strs as $str)
		{
			$encodeds[] = urlencode($str);
		}
		return $encodeds;
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

if (!function_exists('trim_bothend_space'))
{

	function trim_bothend_space($str)
	{
		return preg_replace('#[\s 　]*(.*?)[\s 　]*#u', '\1', $str);
	}

}

if (!function_exists('array_reflect_func'))
{

	function array_reflect_func(array $array, $callback)
	{
		if (!is_callable($callback))
		{
			return FALSE;
		}

		foreach ($array as &$value)
		{
			if (is_array($value))
			{
				$value = array_reflect_func($value, $callback);
			}
			else 
			{
				$value = call_user_func($callback, $value);
			}
		}
		return $array;
	}
}

if (!function_exists('jump_back'))
{

	function jump_back($num = 1)
	{
		?><script type="text/javascript">window.history.go(-<?= $num ?>)</script><?php
		exit;
	}

}