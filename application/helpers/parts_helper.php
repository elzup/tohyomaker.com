<?php

if (!function_exists('tag_icon'))
{

	function tag_icon($class, $is_color = FALSE, $color = 'orange')
	{
		if ($is_color)
		{
			$class .= ' icon-' . $color;
		}
		return '<i class="' . $class . '"></i>';
	}

}

if (!function_exists('attr_hoge_link'))
{

	function attr_hoge_link($attr_name, $type = PATH_TOP, $values = NULL, $is_wrap_base = TRUE)
	{
		$link = $type;
		if ($link == '#' || $link == '/')
		{
			return $attr_name . '="' . $link . '"';
		}
		// TODO: support array $option_value args
		if (!empty($values))
		{
			if (!is_array($values))
			{
				$values = explode('/', $values);
			}
			$link .= '/' . implode('/', urlencode_array($values));
		}

		if ($is_wrap_base)
		{
			$link = base_url($link);
		}
		return $attr_name . '="' . $link . '"';
	}

}

if (!function_exists('attr_href'))
{

	function attr_href($type = PATH_TOP, $values = NULL, $is_wrap_base = TRUE)
	{
		return attr_hoge_link('href', $type, $values, $is_wrap_base);
	}

}

if (!function_exists('attr_src'))
{

	function attr_src($type = PATH_TOP, $values = NULL, $is_wrap_base = TRUE)
	{
		return attr_hoge_link('src', $type, $values, $is_wrap_base);
	}

}

if (!function_exists('attr_tooltip'))
{

	function attr_tooltip($str)
	{
		return ' data-toggle="tooltip" data-placement="top" title="' . $str . '"';
	}

}


