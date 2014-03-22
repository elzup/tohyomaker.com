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

	function totext_share($itemname, $survey_title)
	{
		return "「{$itemname} 」に投票しました : {$survey_title}";
	}

}

if (!function_exists('totext_share_result'))
{

	/**
	 * 
	 * @param Itemobj[] $items
	 * @param string $result_title
	 * @param string $survey_title
	 * @param int $itemrank
	 * @return string
	 */
	function totext_share_result($items, $result_title, $survey_title, $itemrank = 3)
	{
		$text = "{$survey_title}[{$result_title}]\n";
		$i = 1;
		foreach ($items as $item)
		{
			if ($i > $itemrank)
			{
				break;
			}
			$text .= "{$item->rank}位:{$item->value}[{$item->num}]\n";
		}
		return $text;
	}

}