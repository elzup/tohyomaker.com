<?php

class Surveyobj
{

	public $id;
	public $title;
	public $description;
	public $timestamp;
	public $state;
	public $num_item;
	public $is_anonymous;
	public $target;
	public $total_num;

	/** @var Userobj */
	public $owner;

	/** @var Itemobj[] */
	public $items;
	private $items_sorted;
	public $tags;

	/** @var Resultobj[] */
	public $results;

	/** @var Resultobj */
	public $current_result;
	public $point_hot;

	/** @deprecated */
	public $point_relevant;

	/* super optional */
	public $selected;

	function __construct($data = NULL, array $items = NULL, array $tags = NULL, Userobj $owner = NULL, $selected = NULL, $results = NULL)
	{
		$this->selected = NO_VOTED;
		if (!empty($data))
		{
			$this->set($data, $items, $tags, $owner, $selected, $results);
		}
	}

	function set(stdClass $data, array $items = NULL, array $tags = NULL, Userobj $owner = NULL, $selected = NULL, $results = NULL)
	{
		$this->id = h($data->id_survey);
		$this->title = h($data->title);
		$this->target = (empty($data->target) ? '' : h($data->target));
		$this->description = (empty($data->description) ? '' : h($data->description));
		$this->num_item = $data->num_item;
		$this->timestamp = $data->timestamp;
		$this->state = $data->state;
		$this->is_anonymous = !empty($data->is_anonymous);
		$this->total_num = $data->total_num;

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
			$item = new Itemobj($datum);
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
			return NULL;
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
		$result = new Resultobj($data, $items_sorted);
		$result->set_elapsed_time(strtotime($this->timestamp));
		return $result;
	}

	public function get_current_result()
	{
		if ($this->state != SURVEY_STATE_PROGRESS)
		{
			return $this->results[0];
		}
		return $this->current_result ? : $this->install_current_result();
	}

	public function install_current_result()
	{
		$data = new stdClass();
		$data->type = RESULT_TYPE_CURRENT;
		$data->timestamp = date(MYSQL_TIMESTAMP);
		return $this->current_result = new Resultobj($data, $this->items, $this->get_time_progress_str());
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

	public function get_time_progress_str($is_full = FALSE)
	{
		if ($this->state != SURVEY_STATE_PROGRESS)
		{
			return '終了[3日]';
		}
		$time = $this->get_time_progress();
		return to_time_resolution_str($time, $is_full);
	}

	public function get_time_remain_str()
	{
		$remain = $this->get_time_remain() - strtotime('+4 day', 0);
		if ($remain < 0)
		{
			return '終了';
		}
		$times = to_time_resolution($remain, TRUE);
		// TODO: 
		return 'あと'.($times->d ? $times->df : $times->h ? : $times->m ? : $remain . '秒');
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
	 * @return Itemobj[]
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

			function cmp_item(Itemobj $a, Itemobj $b)
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

	public function update_regist_vote($value)
	{
		$this->items[$value]->num++;
		$this->total_num++;
	}

	public function check_just()
	{
		$lib = array(
				100 => RESULT_TYPE_V100,
				500 => RESULT_TYPE_V500,
				1000 => RESULT_TYPE_V1000,
				5000 => RESULT_TYPE_V5000,
				10000 => RESULT_TYPE_V10000,
		);
		if (isset($lib[$this->total_num]))
		{
			return $lib[$this->total_num];
		}
		return FALSE;
//		return @$lib[$this->total_num] ?: FALSE;
	}

	public function get_result_num()
	{
		return count($this->results);
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
	 * @return Itemobj
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
