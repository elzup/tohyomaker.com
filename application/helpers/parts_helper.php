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


if (!function_exists('attr_href'))
{

	function attr_href($type = PATH_TOP, $values = NULL, $is_wrap_base = TRUE)
	{
		$link = $type;
		if ($link == '#') {
			return 'href="#"';
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
		return 'href="' . $link . '"';
	}

}

if (!function_exists('attr_tooltip'))
{

	function attr_tooltip($str)
	{
		return ' data-toggle="tooltip" data-placement="top" title="' . $str . '"';
	}

}


