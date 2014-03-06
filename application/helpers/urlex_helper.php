<?php

if (!function_exists('base_url')) {
	die('not loaded url_helper');
}


if (!function_exists('url_make_end'))
{
	function url_make_end($id_survey, $token)
	{
		return base_url("make/end/{$id_survey}/{$token}");
	}
}

if (!function_exists('url_vote'))
{
	function url_vote($id_survey, $index)
	{
		return base_url("{$id_survey}/{$index}");
	}
}