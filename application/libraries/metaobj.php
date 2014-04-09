<?php

class Metaobj
{

	private $title;
	private $title_meta;
	public $description;
	/* @var $keywords array */
	public $keywords;
	public $url;
	private $type;

	public $no_meta;
	public $no_og;

	public function __construct()
	{
		$this->title = '投票メーカー';
		$this->title_meta = '投票メーカー';
		$this->keywords = array();
		$this->keywords[] = '投票';
		$this->keywords[] = 'Twitter';
		$this->type = 'article';
		$this->no_meta = FALSE;
		$this->no_og = FALSE;
	}


	public function unset_type()
	{
		$this->type = FALSE;
	}

	public function get_type()
	{
		return $this->type;
	}

	public function get_title($is_meta = FALSE)
	{
		return $is_meta ? $this->title_meta : $this->title;
	}

	public function set_title($str)
	{
		$this->title = $str;
		$this->title_meta = $str;
//		$this->title = $str;
//		$this->title_meta = $str . ' - '.SITE_NAME;
	}

	public function set_keyword($str)
	{
		array_unshift($this->keywords, $str);
	}

	public function get_keywords_text()
	{
		return implode(',', $this->keywords);
	}

	// call methods to setup several page case
	public function setup_top()
	{
		$this->url = base_url();
		$this->description = SITE_DESCRIPTION;
		$this->type = 'website';
	}

	public function setup_make()
	{
		$this->set_title('投票作成');
		$this->url = base_url(PATH_MAKE);
		$this->description = 'オリジナルの投票を気軽に作成することが出来ます';
	}

	public function setup_login()
	{
		$this->set_title('ログイン');
		$this->url = base_url(PATH_LOGIN);
		$this->description = 'Twitter認証でログインを出来ます';
	}

	public function setup_catalog_hot()
	{
		$this->set_title('人気の投票');
		$this->url = base_url(PATH_HOT);
		$this->description = '今人気のある投票の一覧';
	}

	public function setup_catalog_new()
	{
		$this->set_title('新着投票');
		$this->url = base_url(PATH_NEW);
		$this->description = '最近作成された投票の新着順一覧';
	}

	public function setup_my()
	{
		$this->set_title('マイページ');
		$this->url = base_url(PATH_MYPAGE);
		$this->no_meta = TRUE;
	}

	public function setup_user($user_name)
	{
		$this->set_title($user_name . 'さんが作成した投票');
		$this->url = base_url(PATH_NEW);
		$this->no_og = TRUE;
		$this->description = $user_name . 'さんが作成した投票';
	}

	public function setup_search_tag($tag_name)
	{
		$this->set_title($tag_name . 'タグの投票');
		$this->url = base_url(PATH_TAG);
		$this->no_og = TRUE;
		$this->description = $tag_name .'タグのついた投票の検索結果';
	}

	public function setup_survey(Surveyobj $survey, $is_view = FALSE)
	{
		$this->set_title($survey->title . ($is_view ? ':結果' : ''));
		$this->set_keyword($survey->title . ($is_view ? 'の投票結果' : ''));
		if (isset($survey->tags[0]))
		{
			$this->keywords[] = $survey->tags[0];
		}
		if (isset($this->description))
		{
			$this->description = ($is_view ? '投票結果: ' : '投票ページ: ') . $survey->description;
		} else
		{
			$this->description = $survey->title . ($is_view ? 'の投票結果' : 'に投票しよう');
		}
	}
}
