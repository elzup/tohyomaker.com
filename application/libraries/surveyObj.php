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

/**
 * 
 * @see $selected
 */
define('NO_VOTED', -1);

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

	/** @var UserObj */
	public $owner;

	/** @var ItemObj[] */
	public $items;
	private $items_sorted;
	public $tags;
	public $results;

	public $point_hot;

	/* super optional */
	public $selected;

	function __construct($data = NULL, array $items = NULL, array $tags = NULL, UserObj $owner = NULL, $selected = NULL, $results = NULL)
	{
		$this->selected = NO_VOTED;
		if (!empty($data))
		{
			$this->set($data, $items, $tags, $owner, $selected, $results);
		}
	}

	function set(stdClass $data, array $items = NULL, array $tags = NULL, UserObj $owner = NULL, $selected = NULL, $results = NULL)
	{
		$this->id = h($data->id_survey);
		$this->title = h($data->title);
		$this->target = (empty($data->target) ? '' : h($data->target));
		$this->description = (empty($data->description) ? '' : h($data->description));
		$this->num_item = $data->num_item;
		$this->timestamp = $data->timestamp;
		$this->state = $data->state;
		$this->is_anonymous = empty($data->is_anonymous);

		if (isset($items))
		{
			$this->set_items($items);
		}
		if (isset($tags))
		{
			$this->set_tags($tags);
		}
		if (isset($owner))
		{
			$this->owner = $owner;
		}
		// after set items
		if (isset($results))
		{
			$this->set_results($results);
		}
		if (isset($selected))
		{
			$this->selected = $selected;
		} 
	}

	public function set_items(array $data)
	{
		$this->items = array();
		$this->items = $this->create_items($data);
	}

	public function create_items($data)
	{
		$items = array();
		foreach ($data as $datum)
		{
			$item = new ItemObj($datum);
			$items[$item->index] = $item;
		}
		ksort($items);
		return $items;
	}

	public function set_tags(array $data)
	{
		$this->tags = array();
		foreach ($data as $datum)
		{
			$this->tags[] = h($datum->value);
		}
	}

	public function set_results(array $data)
	{
		if (!isset($data))
		{
			return FALSE;
		}
		$this->results = $this->create_results($data);
	}

	public function create_results($data)
	{
		if (!isset($this->items))
		{
			return FALSE;
		}
		$results = array();
		foreach ($data as $datum)
		{
			$results[] = $this->_create_result($datum);
		}
		return $results;
	}

	private function _create_result($data)
	{
		$nums = explode(',', $data->result);
		$items = $this->_create_map_item($nums);
		$items_sorted = $this->create_sorted_items($items);
		$result = new ResultObj($data, $items_sorted);
		$result->set_elapsed_time(strtotime($this->timestamp));
		return $result;
	}

	private function _create_map_item($nums)
	{
		$items = array();
		foreach ($this->items as $item)
		{
			$items[] = clone $item;
		}
		foreach ($nums as $i => $num)
		{
			$items[$i]->num = $num;
		}
		return $items;
	}

	public function get_total()
	{
		$sum = 0;
		foreach ($this->items as $item)
		{
			$sum += $item->num;
		}
		return $sum;
	}

	public function get_text_items($glue = ' / ')
	{
		$itemnames = array();
		foreach ($this->items as $item)
		{
			$itemnames[] = $item->value;
		}
		return implode($glue, $itemnames);
	}

	public function get_state_update()
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
		if ($this->state === SURVEY_STATE_END)
		{
			return 100;
		}
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
		if ($remain < 0) {
			return '終了';
		}
		if ($remain < 3600)
		{
			return 'あと'.floor($remain / 60) . '分';
		} elseif ($remain < 86400)
		{
			return 'あと'.floor($remain / 3600) . '時間';
		}
		return 'あと'.floor($remain / 86400) . '日';
	}

	public function get_time_remain()
	{
		if ($this->state === SURVEY_STATE_END)
		{
			return 0;
		}
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

	/**
	 * 
	 * @return ItemObj[]
	 */
	public function get_sorted()
	{
		if (!isset($this->items_sorted))
		{
			$this->items_sorted = $this->create_sorted_items($this->items);
		}
		return $this->items_sorted;
	}

	public function create_sorted_items($items)
	{

		//sort to base ItemObj's field num
		if (!function_exists('cmp_item'))
		{

			function cmp_item(ItemObj $a, ItemObj $b)
			{
				if ($a->num == $b->num)
				{
					return 0;
				}
				return ($a->num < $b->num) ? 1 : -1;
			}

		}

		usort($items, 'cmp_item');
		$this->_rank_item($items);
		return $items;
	}

	private function _rank_item(&$items_sorted)
	{
		if (!isset($items_sorted))
		{
			return false;
		}
		$pre_n = -1;
		$rank = 0;
		for ($i = 0; $i < count($items_sorted); $i++)
		{
			$n = $items_sorted[$i]->num;
			if ($pre_n != $n)
			{
				$rank = $i + 1;
			}
			$items_sorted[$i]->set_rank($rank);
			$pre_n = $n;
		}
	}

	public function get_result_text()
	{
		$results = array();
		foreach ($this->items as $item)
		{
			$results[] = $item->num;
		}
		return implode(',', $results);
	}

	/*
	 * support voted item 
	 */

	/**
	 * 
	 * @return boolean
	 */
	public function is_voted()
	{
		return $this->selected !== NO_VOTED;
	}

	/**
	 * 
	 * @return ItemObj
	 */
	public function get_selected_item()
	{
		if (!$this->is_voted())
		{
			return NULL;
		}
		return $this->items[$this->selected];
	}
}
