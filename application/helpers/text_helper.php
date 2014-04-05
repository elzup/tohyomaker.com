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

	function totext_share_voted($itemname, $survey_title)
	{
		return "「{$itemname}」に投票しました : {$survey_title}";
	}

}

if (!function_exists('totext_share_survey'))
{

	function totext_share_survey(Surveyobj $survey)
	{
		return "{$survey->title} [{$survey->get_time_remain_str()}]";
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
	function totext_share_result(Surveyobj $survey, $result = NULL, $itemrank = 3)
	{
		if (empty($result))
		{
			$result = $survey->get_current_result();
		}
		$text = "投票結果:{$survey->title} \n";
		$i = 1;
		foreach ($result->items as $item)
		{
			if ($item->rank > $itemrank || $i++ > 5)
			{
				break;
			}
			$text .= "{$item->rank}位:{$item->value}[{$item->num}]\n";
		}
		return $text;
	}

}