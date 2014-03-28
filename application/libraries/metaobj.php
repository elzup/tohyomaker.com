<?php

class Metaobj
{

	public $title;
	public $description;
	/* @var $keywords array */
	public $keywords;
	public $url;
	public $type;

	public function __construct()
	{
		$this->keywords = array();
		$this->keywords[] = '投票';
		$this->keywords[] = 'Twitter';
		$this->type = 'article';
	}

	public function set_survey(Surveyobj $survey)
	{
		$this->title = $survey->title . ' - 投票メーカー';
		$this->keywords[] = $survey->title;
		if (isset($survey->tags[0]))
		{
			$this->keywords[] = $survey->tags[0];
		}
		$this->description = @$survey->description ? : ($survey->title . 'に投票しよう');
	}

	public function get_keywords_text()
	{
		return implode(',', $this->keywords);
	}

}
