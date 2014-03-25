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

if (!function_exists('totext_result_type'))
{

	function totext_result_type($type)
	{
		$lib = array(
				RESULT_TYPE_H1 => '経過時間1時間',
				RESULT_TYPE_H6 => '経過時間6時間',
				RESULT_TYPE_HC => '経過時間12時間',
				RESULT_TYPE_D1 => '経過時間1日',
				RESULT_TYPE_D2 => '経過時間2日',
				RESULT_TYPE_D3 => '経過時間3日',
				RESULT_TYPE_V100 => '投票数100票',
				RESULT_TYPE_V500 => '投票数500票',
				RESULT_TYPE_V1000 => '投票数1000票',
				RESULT_TYPE_V5000 => '投票数5000票',
				RESULT_TYPE_V10000 => '投票数10000票',
		);
		return @$lib[$type] ? : '';
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
		$text = "投票結果:{$survey->title} [{$result->get_type_text()}時点]\n";
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