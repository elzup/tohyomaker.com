<?php

if (!function_exists('totext_voted'))
{

	function totext_voted($itemname)
	{
		return "{$itemname} に投票しました。";
	}

}

if (!function_exists('totext_share'))
{

	function totext_share($itemname, $survey_title, $url)
	{
		return "「{$itemname} 」に投票しました : {$survey_title} {$url}";
	}

}