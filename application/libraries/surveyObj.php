<?php

/**
 * anable vote working
 * @see $state
 */
define('SURVEY_STATE_PROGRESS', '0');
/**
 * vote is finish, saveing vote record
 * @see $state
 */
define('SURVEY_STATE_RESULT', '1');
/**
 * saving only result
 * @see $state
 */
define('SURVEY_STATE_END', '2');

/**
 * timestamp string format
 * @see $state
 */
define('DATE_FORMAT', 'Y年m月d日 H:i');


class SurveyObj
{

	public $id;
	public $title;
	public $description;
	public $timestamp;
	public $state;
	public $num_item;
	public $is_anonymous;
	public $target;

	/**
	 *
	 * @var UserObj
	 */
	public $owner;
	public $items;
	public $tags;
	public $result;

	function __construct($data = NULL, array $items = NULL, $tags = NULL, $owner = NULL)
	{
		if (!isset($data))
			return;
		$this->set($data, $items, $tags, $owner);
	}

	function set($data, array $items = NULL, $tags = NULL, $owner = NULL)
	{
		$this->id = $data->id_survey;
		$this->title = $data->title;
		$this->target = (empty($data->target) ? '' : $data->target);
		$this->description = (empty($data->description) ? '' : $data->description);
		$this->num_item = $data->num_item;
		$this->timestamp = $data->timestamp;
		$this->state = $data->state;
		$this->is_anonymous = empty($data->is_anonymous);

		$this->result = array();
		$this->items = array();
		$this->tags = array();

		for ($i = 0; $i < $this->num_item; $i++)
		{
			$this->owner = $owner;
		}

		for ($i = 0; $i < $this->num_item; $i++)
		{
			$this->result[$i] = 0;
		}
		if (isset($items))
		{
			$this->set_item($items);
		}
		if (isset($tags))
		{
			$this->set_tag($tags);
		}
		$this->get_time_remain();
	}

	public function set_item($items)
	{
		foreach ($items as $item)
		{
			$this->items[$item->index] = $item->value;
			$this->result[$item->index] = $item->num;
		}
	}

	public function set_tag($tags)
	{
		foreach ($tags as $tag)
		{
			$this->tags[] = $tag->value;
		}
	}

	public function get_total()
	{
		return array_sum($this->result);
	}

	public function get_text_items($glue = ' / ')
	{
		return implode($glue, $this->items);
	}

	public function get_state_update ()
	{
		if ($this->state == SURVEY_STATE_END)
		{
			return FALSE;
		}
		$remain = $this->get_time_remain();
		if ($remain <= 0)
		{
			return SURVEY_STATE_END;
		}
		if ($remain <= 345600)
		{
			return SURVEY_STATE_RESULT;
		}
		return FALSE;
	}

	public function get_time_progress_par()
	{
		$progress_time = $this->get_time_progress();
		$day3_time = strtotime('+3 day', 0);
		$v = $progress_time * 100 / $day3_time;
		return round($v);
	}

	public function get_time_progress()
	{
		$start_time = strtotime($this->timestamp);
		$now = time();
		return $now - $start_time;
	}

	public function get_time_remain_str()
	{
		$remain = $this->get_time_remain() - strtotime('+4 day', 0);
		if ($remain < 3600)
		{
			return floor($remain / 60) . '分';
		}
		elseif ($remain < 86400)
		{
			return floor($remain / 3600) . '時間';
		}
			return floor($remain / 86400) . '日';
	}

	public function get_time_remain()
	{
		// TODO: create another type case 
		$start_time = strtotime($this->timestamp);
		$end_time = strtotime('+1 week', $start_time);
		$now = time();
		return $end_time - $now;
	}

	public function get_time()
	{
		return date(DATE_FORMAT, strtotime($this->timestamp));
	}

}
