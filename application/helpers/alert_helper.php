<?php

if (!function_exists('set_alert'))
{

	/**
	 * @deprecated
	 */
	function set_alert($type)
	{
		return setcookie(ALERT_PREFIX . $type , '1', time() + 60);
	}

}

if (!function_exists('get_alert'))
{

	/**
	 * @deprecated
	 */
	function get_alert()
	{
		$cookies = filter_input_array(INPUT_COOKIE);
		?> <div class="col-sm-row"><?php
		if (!empty($cookies))
		{
			foreach ($cookies as $key => $value)
			{
				$pattern = '#^' . ALERT_PREFIX . '(.+)#';
				if ($value == 1 && preg_match($pattern, $key, $matches))
				{
					?> <div class="col-sm-offset-1 col-sm-10"><?php
							$type = $matches[1];
							alert_box($type);
							setcookie($key, "unset", time() - 3600);
							?> </div><?php
					}
				}
				?> </div><?php
		}
	}

}